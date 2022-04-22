<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
use App\Models\Department;
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

    public function store(DepartmentRequest $request){
        $newDar = new Department();
        $newDar->title = $request->title;
        $newDar->save();
        if(request('add_more')){
            return redirect("/department/create")->with("success","User has been successfully created .");
        }
        return redirect("/department")->with("success","User has been successfully created .");
    }

    public function edit(Department $department){
        
        return view('department.edit',[
            "department"=>$department
        ]);
    }
    
    public function update(DepartmentRequest $request , Department $department){
        $department->title = $request->title;
        
        $department->save();
        return redirect('/department')->with("success","Role has been successfully updated .");
    }


    public function destroy(Department $department){
        $department->delete();
        return 'success';
    }

}
