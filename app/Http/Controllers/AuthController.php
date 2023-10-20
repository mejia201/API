<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens as SanctumHasApiTokens;

class AuthController extends Controller
{
    use SanctumHasApiTokens;


    public function create(Request $request){

        $rules =[

            'name' => 'required|string|max:200',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:8'
        ];

        $mensajePersonalizado = [
            'email.unique' => 'Este correo ya existe, prueba con otro. ',
            'password.min' => ' La contraseña debe tener al menos 8 caracteres.'
        ];

        $validator = Validator::make($request->input(), $rules, $mensajePersonalizado);
        if($validator->fails()){

            return response()->json([
                'status'=> false,
                'errors' => $validator->errors()->all()
            ], 400);

        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([

            'status'=> true,
            'message' => 'Usuario creado exitosamente',
            'token' => $user->createToken('API TOKEN')->plainTextToken

        ], 200);

    }


    public function login(Request $request){

        $rules =[

            'email' => 'required|string|email|max:100',
            'password' => 'required|string'
        ];

        $validator = Validator::make($request->input(), $rules);
        if($validator->fails()){

            return response()->json([
                'status'=> false,
                'errors' => $validator->errors()->all()
            ], 400);

        }

        if(!Auth::attempt($request->only('email', 'password'))){

            return response()->json([
                'status'=> false,
                'errors' => ['Sin autorizacion']
            ], 401);

        }

        $user = User::where('email', $request->email)->first();

        return response()->json([

            'status'=> true,
            'message' => 'Inicio de sesión exitoso',
            'data' => $user,
            'token' => $user->createToken('API TOKEN')->plainTextToken

        ], 200);

    }

    public function logout(Request $request){
        
        $user = $request->user();
    
        if ($user) {
            $user->tokens->each(function ($token) {
                $token->delete();
            });
    
            return response()->json([
                'status' => true,
                'message' => 'Se ha cerrado la sesión exitosamente'
            ], 200);
        }
    
        return response()->json([
            'status' => false,
            'message' => 'No se encontró ningún usuario autenticado'
        ], 401);

    }

}
