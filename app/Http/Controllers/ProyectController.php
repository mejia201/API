<?php

namespace App\Http\Controllers;

use App\Models\Proyect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProyectController extends Controller
{
   
    public function index()
    {
        $proyects = Proyect::select('proyects.*'
        , 'employees.name as employee')
        ->join('employees','employees.id', '=', 'proyects.employee_id')
        ->paginate(10);

        return response()->json($proyects);
    }

   
    public function store(Request $request)
    {

        $rules = [
            'name' => 'required|string|min:1|max:200|unique:proyects',
            'duration' => 'required|integer',
            'description' => 'required|string',
            'status' => 'required|in:En progreso,Completado,Pendiente',
            'employee_id' => 'required|exists:employees,id',
        ];

        $mensajePersonalizado = [
            'name.unique' => 'Este proyecto ya existe, prueba con otro nombre.',
        ];

        $validator = Validator::make($request->input(), $rules, $mensajePersonalizado);

        if($validator->fails()){

            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()

            ], 400);
        }

        $proyect = new Proyect($request->input());

        $proyect->save();

        return response()->json([

            'status'=> true,
            'message' => 'Proyecto guardado exitosamente'

        ], 200);
        
    }

    
    public function show(Proyect $proyect)
    {
        return response()->json(['status' => true, 'data' => $proyect]);

    }

    
    public function update(Request $request, Proyect $proyect)
    {

        $rules = [
            'name' => 'required|string|min:1|max:200|unique:proyects,name,'. $proyect->id,
            'duration' => 'required|integer',
            'description' => 'required|string',
            'status' => 'required|in:En progreso,Completado,Pendiente',
            'employee_id' => 'required|exists:employees,id',
        ];

        $mensajePersonalizado = [
            'name.unique' => 'Este proyecto ya existe, prueba con otro nombre.',
        ];

        $validator = Validator::make($request->input(), $rules, $mensajePersonalizado);

        if($validator->fails()){

            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()

            ], 400);
        }


        $proyect->update($request->input());

        return response()->json([

            'status'=> true,
            'message' => 'Proyecto actualizado exitosamente'

        ], 200);
        
    }

    
    public function destroy(Proyect $proyect)
    {

        $proyect->delete();

        return response()->json([

            'status'=> true,
            'message' => 'Proyecto eliminado exitosamente'

        ], 200);
        
    }

    public function ProyectsByEmployee(){

        $proyects = Proyect::select(DB::raw('count(proyects.id) as count, employees.name'))
        ->rightjoin('employees', 'employees.id', '=', 'proyects.employee_id')
        ->groupBy('employees.name')->get();

        return response()->json($proyects);

    }

    public function all(){

        $proyects = Proyect::select('proyects.*'
        , 'employees.name as employee')
        ->join('employees','employees.id', '=', 'proyects.employee_id')
        ->get();

        return response()->json($proyects);
    }


    public function getProyectCount()
    {


    $proyects = Proyect::count();
    
    return response()->json(['proyects' => $proyects]);

    }
}
