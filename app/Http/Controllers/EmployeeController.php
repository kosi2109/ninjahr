<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Yajra\Datatables\Datatables;

class EmployeeController extends Controller
{

    public function index()
    {
        return view("employee.index");
    }

    public function ssd()
    {
        $employee = User::with("department");
        return DataTables::of($employee)
        ->filterColumn('department_name',function($query, $keyword){
            $query->whereHas('department',function($q1) use($keyword) {
                $q1->where('title','like','%'.$keyword.'%');
            });
        })
        ->editColumn('profile_img',function($each){
            return "<div class='d-flex flex-column justify-content-center align-items-center'><img src='/storage/". $each->profile_img ."' alt='' class='profile-thumb' /> <p>".$each->name."</p></div>";
        })
        ->addColumn('department_name',function($each){
            return $each->department ? $each->department->title : "-";
        })
        ->addColumn('role_name',function($each){
            $html = "";
            foreach($each->roles as $role){
                $html .= "<span class='badge badge-pill bg-success m-1'>$role->name</span>";
            };
        
            return $html;
        })
        ->addColumn('action',function($each){
            $edit = "";
            $info = "";
            $delete = "";
            if(auth()->user()->can('edit_employee')){
                $edit = "<a href='/employee/". $each->id ."/edit' class='text-decoration-none'>
                <button class='btn btn-sm btn-outline-warning' style='width:40px' ><i class='fa-solid fa-pen-to-square'></i></button></a>";
            };
            if(auth()->user()->can('view_employee')){
                $info = "<a href='/employee/". $each->id ."/show' class='text-decoration-none'>
                <button class='btn btn-sm btn-outline-primary' style='width:40px'><i class='fa-solid fa-info'></i></button></a>";
            }
            if(auth()->user()->can('delete_employee')){
                $delete = "
                <button data-id=". $each->id ." class='btn btn-sm btn-outline-danger delete' style='width:40px'><i class='fa-solid fa-trash-alt'></i></button>";
            }
            return "<div>$edit $info $delete</div>";
        })
        ->editColumn('is_present',function($each){
            if($each->is_present == 1){
                return '<span class="badge rounded-pill bg-success">Present</span>';
            }else{
                return '<span class="badge rounded-pill bg-danger">Leaft</span>';
            };
        })
        ->editColumn('updated_at',function($each){
            return Carbon::parse($each->updated_at)->format('d-m-Y H:i:s');
           
        })
        ->rawColumns(['role_name','profile_img','is_present','action'])
        ->make(true);
    }

    public function create(){
        $departments = Department::all()->sortBy('title');
        $roles = Role::all()->sortBy('name');
        return view('employee.create',[
            "departments" => $departments,
            'roles'=> $roles
        ]);
    }

    public function store(){
       
        $image = null;
        if(request()->hasFile('profile_img')){
            $image = request()->file('profile_img')->store('employee');
        }
        
        $user = request()->validate([
            "employee_id" => ["required",Rule::unique('users','employee_id')],
            "name" => ["required"],
            "password" => ["required"],
            "phone" => ["required",Rule::unique('users','phone')],
            "email" => ["required",Rule::unique('users','email')],
            "nrc_number" => ["required",Rule::unique('users','nrc_number')],
            "gender" => ["required"],
            "birthday" => ["required"],
            "address" => ["required"],
            "department_id" => ["required",Rule::exists('departments','id')],
            "date_of_join" => ["required"],
            "is_present" => ["required"],
        ]);
        $user["password"] = Hash::make(request("password"));
        $user["profile_img"] = $image;
        $newUser = User::create($user);
        $newUser->syncRoles(array_values(request('role_id')));
        if(request('add_more')){
            return redirect("/employee/create")->with("success","User has been successfully created .");
        }
        return redirect("/employee")->with("success","User has been successfully created .");
    }

    public function edit(User $user){
        $departments = Department::all()->sortBy('title');
        $roles = Role::all()->sortBy('name');
        return view('employee.edit',[
            "employee"=>$user,
            "departments"=>$departments,
            'roles' => $roles
        ]);
    }
    
    public function update(User $user){
        if(request()->hasFile('profile_img')){
            $image = request()->file('profile_img')->store('employee');
            $user["profile_img"] = $image;
        }
        $formData = request()->validate([
            "employee_id" => ["required",Rule::unique('users','employee_id')->ignore($user->id)],
            "name" => ["required"],
            "phone" => ["required",Rule::unique('users','phone')->ignore($user->id)],
            "email" => ["required",Rule::unique('users','email')->ignore($user->id)],
            "nrc_number" => ["required",Rule::unique('users','nrc_number')->ignore($user->id)],
            "gender" => ["required"],
            "birthday" => ["required"],
            "address" => ["required"],
            "department_id" => ["required",Rule::exists('departments','id')],
            "date_of_join" => ["required"],
            "is_present" => ["required"]
        ]);
        
        if(isset(request()->password)){
            $user->password = Hash::make(request()->password) ;
        };
        
        foreach($formData as $key=>$value){
            $user->$key = $value;
        };
        $user->syncRoles(array_values(request('role_id')));
        $user->save();
        return redirect('/employee')->with("success","Employee has been successfully updated .");
    }

    public function show(User $user){
        return view('employee.show',[   
            'user'=> $user
        ]);
    }

    public function destroy(User $user){
        $user->delete();
        return 'success';
    }

}
