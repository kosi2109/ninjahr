<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Yajra\Datatables\Datatables;

class PermissionController extends Controller
{

    public function index()
    {
        return view("permission.index");
    }

    public function ssd()
    {
        $permission = Permission::all();
        return DataTables::of($permission)
        ->addColumn('action',function($each){
            $eidt = "<a href='/permission/". $each->id ."/edit' class='text-decoration-none'>
            <button class='btn btn-sm btn-outline-warning' style='width:40px' ><i class='fa-solid fa-pen-to-square'></i></button></a>";
            $delete = "
            <button data-id=". $each->id ." class='btn btn-sm btn-outline-danger delete' style='width:40px'><i class='fa-solid fa-trash-alt'></i></button>";
            return "<div>$eidt $delete</div>";
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function create(){

        return view('permission.create');
    }

    public function store(){
        
        $formData = request()->validate([
            "name" => ["required"],
        ]);
        
        $permission = new Permission();
        $permission->name = $formData['name'];
        $permission->save();
        if(request('add_more')){
            return redirect("/permission/create")->with("success","Permission has been successfully created .");
        }
        return redirect("/permission")->with("success","Permission has been successfully created .");
    }

    public function edit(Permission $permission){
        
        return view('permission.edit',[
            "permission"=>$permission
        ]);
    }
    
    public function update(Permission $permission){
        $formData = request()->validate([
            "name" => ["required"],
        ]);
        
        foreach($formData as $key=>$value){
            $permission->$key = $value;
        };
        
        $permission->save();
        return redirect('/permission')->with("success","Permission has been successfully updated .");
    }


    public function destory(Permission $permission){
        $permission->delete();
        return 'success';
    }

}
