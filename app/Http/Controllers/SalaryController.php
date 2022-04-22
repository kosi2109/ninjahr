<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalaryRequest;
use App\Models\Salary;
use App\Models\User;
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
            return $each->user ? $each->user->employee_id : "-" ;
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

    public function store(SalaryRequest $request){

        $user = User::where('employee_id',$request->employee_id)->first();

        $salary = new Salary();
        $salary->user_id = $user->id;
        $salary->month = $request->month;
        $salary->ammount = $request->ammount;
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
    
    public function update(SalaryRequest $request,Salary $salary){
        $user = User::where('employee_id',$request->employee_id)->first();
        
        $salary->user_id = $user->id;
        $salary->month = $request->month;
        $salary->ammount = $request->ammount;
        $salary->save();

        return redirect('/salary')->with("success","salary has been successfully updated .");
    }


    public function destroy(Salary $salary){
        $salary->delete();
        return 'success';
    }
}
