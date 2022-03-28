<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Yajra\Datatables\Datatables;

class DepartmentController extends Controller
{

    public function index()
    {
        return view("department.index");
    }

    public function ssd()
    {
        $department = Department::all();
        return DataTables::of($department)
        ->addColumn('action',function($each){
            $eidt = "<a href='/department/". $each->id ."/edit' class='text-decoration-none'>
            <button class='btn btn-sm btn-outline-warning' style='width:40px' ><i class='fa-solid fa-pen-to-square'></i></button></a>";
            $delete = "
            <button data-id=". $each->id ." class='btn btn-sm btn-outline-danger delete' style='width:40px'><i class='fa-solid fa-trash-alt'></i></button>";
            return "<div>$eidt $delete</div>";
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function create(){

        return view('department.create');
    }

    public function store(){
        
        $department = request()->validate([
            "title" => ["required",Rule::unique('users','employee_id')],
        ]);
        
        $newDar = new Department();
        $newDar->title = $department['title'];
        $newDar->save();
        return redirect("/department")->with("success","User has been successfully created .");
    }

    public function edit(Department $department){
        
        return view('department.edit',[
            "department"=>$department
        ]);
    }
    
    public function update(Department $department){
        $formData = request()->validate([
            "title" => ["required",Rule::unique('departments','title')->ignore($department->id)],
        ]);
        
        foreach($formData as $key=>$value){
            $department->$key = $value;
        };
        
        $department->save();
        return redirect('/department')->with("success","Role has been successfully updated .");
    }


    public function destory(Department $department){
        $department->delete();
        return 'success';
    }

}
