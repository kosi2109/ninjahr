<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::middleware("auth")->group(function(){
    Route::get('/', function () {
        return view('index');
    });
    // profile
    Route::get('profile',[ProfileController::class,"show"]);
    // employee
    Route::get('employee',[EmployeeController::class,"index"]);
    Route::get('employee/create',[EmployeeController::class,"create"]);
    Route::post('employee/store',[EmployeeController::class,"store"]);
    Route::get('employee/{user}/edit',[EmployeeController::class,"edit"]);
    Route::get('employee/{user}/show',[EmployeeController::class,"show"]);
    Route::post('employee/{user}/update',[EmployeeController::class,"update"]);
    Route::delete('employee/{user}/delete',[EmployeeController::class,"destory"]);
    Route::get('employee/database/ssd',[EmployeeController::class,"ssd"]);

    // department
    Route::get('department',[DepartmentController::class,"index"]);
    Route::get('department/create',[DepartmentController::class,"create"]);
    Route::post('department/store',[DepartmentController::class,"store"]);
    Route::get('department/{department}/edit',[DepartmentController::class,"edit"]);
    Route::post('department/{department}/update',[DepartmentController::class,"update"]);
    Route::delete('department/{department}/delete',[DepartmentController::class,"destory"]);
    Route::get('department/database/ssd',[DepartmentController::class,"ssd"]);


    // role
    Route::get('role',[RoleController::class,"index"]);
    Route::get('role/create',[RoleController::class,"create"]);
    Route::post('role/store',[RoleController::class,"store"]);
    Route::get('role/{role}/edit',[RoleController::class,"edit"]);
    Route::post('role/{role}/update',[RoleController::class,"update"]);
    Route::delete('role/{role}/delete',[RoleController::class,"destory"]);
    Route::get('role/database/ssd',[RoleController::class,"ssd"]);

    // permission
    Route::get('permission',[PermissionController::class,"index"]);
    Route::get('permission/create',[PermissionController::class,"create"]);
    Route::post('permission/store',[PermissionController::class,"store"]);
    Route::get('permission/{permission}/edit',[PermissionController::class,"edit"]);
    Route::post('permission/{permission}/update',[PermissionController::class,"update"]);
    Route::delete('permission/{permission}/delete',[PermissionController::class,"destory"]);
    Route::get('permission/database/ssd',[PermissionController::class,"ssd"]);
});



require __DIR__.'/auth.php';
