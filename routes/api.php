<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\NasaController;
use App\Http\Controllers\ProyectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('auth/register', [AuthController::class, 'create']);
Route::post('auth/login', [AuthController::class, 'login']);


Route::middleware(['auth:sanctum'])->group(function () {

Route::resource('departments', DepartmentController::class);
Route::get('getdepartmentcount', [DepartmentController::class, 'getDepartmentCount']);

Route::resource('employees', EmployeeController::class);
Route::resource('proyects', ProyectController::class);

Route::get('employeesall', [EmployeeController::class, 'all']);
Route::get('employeesbydepartment', [EmployeeController::class, 'EmployeesByDepartment']);
Route::get('getemployeecount', [EmployeeController::class, 'getEmployeeCount']);


Route::get('proyectsall', [ProyectController::class, 'all']);
Route::get('proyectsbyemployee', [ProyectController::class, 'ProyectsByEmployee']);
Route::get('getproyectcount', [ProyectController::class, 'getProyectCount']);


//NASA

Route::get('/nasa-api', [NasaController::class, 'getNasaData']);
Route::get('/nasa-neo-api', [NasaController::class, 'getNeoData']);


Route::get('auth/logout', [AuthController::class, 'logout']);

});
