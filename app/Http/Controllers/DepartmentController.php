<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{

    public function index()
    {
      
        $department = Department::all();
        return response()->json($department);
    }

    public function store(Request $request)
    {

               $rules =['name' => 'required|string|max:255|unique:departments',
                'description' => 'nullable|string|max:255'];

                $mensajePersonalizado = [
                    'name.unique' => 'El nombre del departamento ya está en uso.'
                ];

        $validator = Validator::make($request->input(), $rules, $mensajePersonalizado);

        if($validator->fails()){

        return response()->json([

            'status'=> false,
            'errors' => $validator->errors()->all()

        ], 400);
        }

        $department = new Department($request->input());
        $department->save();

        return response()->json([

        'status'=> true,
        'message' => 'Departamento creado exitosamente'

        ], 200);

   
        
        
    }


    public function show(Department $department)
    {

        return response()->json(['status' => true, 'data' => $department]);


        
    }

 
    public function update(Request $request, Department $department)
    {

         $rules =['name' => 'required|string|max:255|unique:departments,name,' . $department->id,
                 'description' => 'nullable|string|max:255'];


                 $mensajePersonalizado = [
                    'name.unique' => 'El nombre del departamento ya está en uso.'
                ];
        
        $validator = Validator::make($request->input(), $rules, $mensajePersonalizado);

        if($validator->fails()){

            return response()->json([

                'status'=> false,
                'errors' => $validator->errors()->all()

            ], 400);
        }

        $department->update($request->input());

        return response()->json([

            'status'=> true,
            'message' => 'Departamento actualizado exitosamente'

        ], 200);

    
        
    }

  
    public function destroy(Department $department)
    {

        $department->delete();

        return response()->json([

            'status'=> true,
            'message' => 'Departamento eliminado exitosamente'

        ], 200);
        
    }

    public function getDepartmentCount()
    {


    $departments = Department::count();
    
    return response()->json(['departments' => $departments]);

    }
    
}
