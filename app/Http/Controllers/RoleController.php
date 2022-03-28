<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\Datatables\Datatables;

class RoleController extends Controller
{

    public function index()
    {
        return view("role.index");
    }

    public function ssd()
    {
        $role = Role::all();
        return DataTables::of($role)
        ->addColumn('action',function($each){
            $eidt = "<a href='/role/". $each->id ."/edit' class='text-decoration-none'>
            <button class='btn btn-sm btn-outline-warning' style='width:40px' ><i class='fa-solid fa-pen-to-square'></i></button></a>";
            $delete = "
            <button data-id=". $each->id ." class='btn btn-sm btn-outline-danger delete' style='width:40px'><i class='fa-solid fa-trash-alt'></i></button>";
            return "<div>$eidt $delete</div>";
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function create(){

        return view('role.create');
    }

    public function store(){
        
        $formData = request()->validate([
            "name" => ["required"],
        ]);
        
        $role = new Role();
        $role->name = $formData['name'];
        $role->save();
        return redirect("/role")->with("success","Role has been successfully created .");
    }

    public function edit(Role $role){
        
        return view('role.edit',[
            "role"=>$role
        ]);
    }
    
    public function update(Role $role){
        $formData = request()->validate([
            "name" => ["required"],
        ]);
        
        foreach($formData as $key=>$value){
            $role->$key = $value;
        };
        
        $role->save();
        return redirect('/role')->with("success","Role has been successfully updated .");
    }


    public function destory(Role $role){
        $role->delete();
        return 'success';
    }

}
