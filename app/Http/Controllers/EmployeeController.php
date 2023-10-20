<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
  
    public function index()
    {
        $employees = Employee::select('employees.*'
        , 'departments.name as department')
        ->join('departments','departments.id', '=', 'employees.department_id')
        ->paginate(10);

        return response()->json($employees);
    }

   
    public function store(Request $request)
    {

        $rules = [
        
            'name' => 'required|string|min:1|max:200',
            'email' => 'required|email|max:80|unique:employees',
            'phone' => 'required|max:15|unique:employees',
            'department_id' => 'required|numeric'

        ];

        $mensajePersonalizado = [
            'email.unique' => 'Este email ya existe, prueba con otro.',
            'phone.unique' => 'Este numero de telefono ya existe, prueba con otro.',
        ];

        $validator = Validator::make($request->input(), $rules, $mensajePersonalizado);

        if($validator->fails()){

            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()

            ], 400);
        }

        $employee = new Employee($request->input());

        $employee->save();

        return response()->json([

            'status'=> true,
            'message' => 'Empleado creado exitosamente'

        ], 200);
        
    }

  
    public function show(Employee $employee)
    {
        return response()->json(['status' => true, 'data' => $employee]);

        
    }

    
    public function update(Request $request, Employee $employee)
    {

        $rules = [
        
            'name' => 'required|string|min:1|max:200',
            'email' => 'required|email|max:80|unique:employees,email,'. $employee->id,
            'phone' => 'required|max:15|unique:employees,phone,'. $employee->id,
            'department_id' => 'required|numeric'

        ];

        $mensajePersonalizado = [
            'email.unique' => 'El email ya está en uso.',
            'phone.unique' => 'El número de telefono ya está en uso.',
        ];

        $validator = Validator::make($request->input(), $rules, $mensajePersonalizado);

        if($validator->fails()){

            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()

            ], 400);
        }

        $employee->update($request->input());

        return response()->json([

            'status'=> true,
            'message' => 'Empleado actualizado exitosamente'

        ], 200);
        
    }

    
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return response()->json([

            'status'=> true,
            'message' => 'Empleado eliminado exitosamente'

        ], 200);
    }

    public function EmployeesByDepartment(){

        $employees = Employee::select(DB::raw('count(employees.id) as count, departments.name'))
        ->rightjoin('departments', 'departments.id', '=', 'employees.department_id')
        ->groupBy('departments.name')->get();

        return response()->json($employees);

    }

    public function all(){

        $employees = Employee::select('employees.*'
        , 'departments.name as department')
        ->join('departments','departments.id', '=', 'employees.department_id')
        ->get();

        return response()->json($employees);
    }


    public function getEmployeeCount()
    {


    $employees = Employee::count();
    
    return response()->json(['employees' => $employees]);

    }
    
}
