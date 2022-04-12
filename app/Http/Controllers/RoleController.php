<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
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
        ->addColumn('permissions',function($each){
            $html = "<div class='row' style='width: 100%'>";
            foreach($each->permissions as $permission){
                $html .= "<div class='col-md-3 align-items-center d-flex justify-content-center'><span class='badge badge-pill bg-success m-1'>$permission->name</span></div>";
            };
        
            return $html.'</div>';
        })
        ->addColumn('action',function($each){
            $eidt = "<a href='/role/". $each->id ."/edit' class='text-decoration-none'>
            <button class='btn btn-sm btn-outline-warning' style='width:40px' ><i class='fa-solid fa-pen-to-square'></i></button></a>";
            $delete = "
            <button data-id=". $each->id ." class='btn btn-sm btn-outline-danger delete' style='width:40px'><i class='fa-solid fa-trash-alt'></i></button>";
            return "<div>$eidt $delete</div>";
        })
        ->rawColumns(['permissions','action'])
        ->make(true);
    }

    public function create(){
        
        $permissions = Permission::all();
        return view('role.create',[
            'permissions' => $permissions
        ]);
    }

    public function store(){
        $formData = request()->validate([
            "name" => ["required"],
        ]);
        
        $role = new Role();
        $role->name = $formData['name'];
        $role->givePermissionTo(request('permissions'));
        $role->save();
        if(request('add_more')){
            return redirect("/role/create")->with("success","Role has been successfully created .");
        }
        return redirect("/role")->with("success","Role has been successfully created .");
    }

    public function edit(Role $role){
        $permissions = Permission::all();
        return view('role.edit',[
            "role"=>$role,
            "permissions"=>$permissions
        ]);
    }
    
    public function update(Role $role){
        $formData = request()->validate([
            "name" => ["required"],
        ]);
        $role->name = $formData['name'];
        $role->revokePermissionTo($role->permissions->pluck('name')->toArray());
        $role->givePermissionTo(request('permissions'));
        $role->save();
        return redirect('/role')->with("success","Role has been successfully updated .");
    }


    public function destroy(Role $role){
        $role->delete();
        return 'success';
    }

}
