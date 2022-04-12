<?php

namespace App\Http\Controllers;

use App\Models\Salary;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SalaryController extends Controller
{
    public function index()
    {
        return view("salary.index");
    }

    public function ssd()
    {
        $salary = Salary::with('user');
        return DataTables::of($salary)
        ->editColumn('user_id',function($each){
            return $each->user->employee_id;
        })
        ->addColumn('action',function($each){
            $eidt = "<a href='/salary/". $each->id ."/edit' class='text-decoration-none'>
            <button class='btn btn-sm btn-outline-warning' style='width:40px' ><i class='fa-solid fa-pen-to-square'></i></button></a>";
            $delete = "
            <button data-id=". $each->id ." class='btn btn-sm btn-outline-danger delete' style='width:40px'><i class='fa-solid fa-trash-alt'></i></button>";
            return "<div>$eidt $delete</div>";
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function create(){

        return view('salary.create');
    }

    public function store(){
        
        $formData = request()->validate([
            "employee_id" => ["required"],
            "month" => ["required"],
            "ammount" => ["required","numeric"],
        ]);
        
        $user = User::where('employee_id',$formData['employee_id'])->first();

        if (!$user){
            return back()->with('error','User with this employee not found .');
        }

        $salary = new Salary();
        $salary->user_id = $user->id;
        $salary->month = $formData['month'];
        $salary->ammount = $formData['ammount'];
        $salary->save();
        if(request('add_more')){
            return redirect("/salary/create")->with("success","salary has been successfully created .");
        }
        return redirect("/salary")->with("success","salary has been successfully created .");
    }

    public function edit(Salary $salary){
        $user = User::where('id',$salary->user_id)->first();

        return view('salary.edit',[
            "user"=>$user,
            "salary"=>$salary
        ]);
    }
    
    public function update(Salary $salary){
        $formData = request()->validate([
            "employee_id" => ["required"],
            "month" => ["required"],
            "ammount" => ["required","numeric"],
        ]);
        
        $user = User::where('employee_id',$formData['employee_id'])->first();

        if (!$user){
            return back()->with('error','User with this employee not found .');
        }
        
        $salary->user_id = $user->id;
        $salary->month = $formData['month'];
        $salary->ammount = $formData['ammount'];
        $salary->save();

        return redirect('/salary')->with("success","salary has been successfully updated .");
    }


    public function destroy(Salary $salary){
        $salary->delete();
        return 'success';
    }
}
