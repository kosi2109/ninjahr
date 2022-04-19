<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendanceRequest;
use App\Models\Attendance;
use App\Models\BiomatericAttedance;
use App\Models\Company;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class AttendanceController extends Controller
{
    public function index()
    {
        
        return view("attendance.index");
    }

    public function ssd()
    {
        $attendance = Attendance::with('user');
        return DataTables::of($attendance)
        ->filterColumn('user_id',function($query, $keyword){
            $query->whereHas('user',function($q1) use($keyword) {
                $q1->where('name','like','%'.$keyword.'%');
            });
        })
        ->editColumn('user_id',function ($each){
            return $each->user ? $each->user->name : '-';
        })
        ->addColumn('action',function($each){
            $eidt ='';
            $delete = '';
            if (auth()->user()->can('edit_attendance')){
                $eidt = "<a href='/attendance/". $each->id ."/edit' class='text-decoration-none'>
                <button class='btn btn-sm btn-outline-warning' style='width:40px' ><i class='fa-solid fa-pen-to-square'></i></button></a>";
            }
            if (auth()->user()->can('delete_attendance')){
                $delete = "
                <button data-id=". $each->id ." class='btn btn-sm btn-outline-danger delete' style='width:40px'><i class='fa-solid fa-trash-alt'></i></button>";
            }
            return "<div>$eidt $delete</div>";
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function create(){
        return view('attendance.create');
    }

    public function store(AttendanceRequest $request){
        if(Carbon::now()->format('D') == 'Sun' || Carbon::now()->format('D') == 'Sat'){
            return back()->with("error","Today is offday");
        }
        
        $employee = User::where('employee_id',$request->employee_id)->first();

        if(!$employee){
            return back()->with("error","User Not Found");
        }

        $machine = BiomatericAttedance::first();
        $exist_attendance = Attendance::where(function($query) use($request,$employee) {
                        $query->where('user_id',$employee->id)
                        ->where('date', $request->date);
                        })->first();

        
        if($exist_attendance){
            return back()->with("error","User has been added for that day .");
        }
        
        $newDar = new Attendance();
        $newDar->biomateric_attedance_id = $machine->id;
        $newDar->user_id = $employee->id;
        $newDar->date = $request->date;

        if (request('check_in')){
            $newDar->check_in = $request->check_in;
        }
        if (request('check_out')){
            $newDar->check_out = $request->check_out;

        }
        $newDar->save();
        if(request('add_more')){
            return redirect("/attendance/create")->with("success","User has been successfully created .");
        }
        return redirect("/attendance")->with("success","User has been successfully created .");
    }

    public function edit(Attendance $attendance){
        return view('attendance.edit',[
            "attendance"=>$attendance
        ]);
    }
    
    public function update(AttendanceRequest $request,Attendance $attendance){
    
        $employee = User::where('employee_id',$request->employee_id)->first();
        $machine = BiomatericAttedance::first();

        if(!$employee){
            return back()->with("error","User Not Found");
        }

        $exist_attendance = Attendance::where(function($query) use($request,$employee) {
            $query->where('user_id',$employee->id)
            ->where('date', $request->date);
        })->first();


        if($exist_attendance && $attendance->id !== $exist_attendance->id ){
            return back()->with("error","User has been added for that day .");
        }

    
        $attendance->biomateric_attedance_id = $machine->id;
        $attendance->user_id = $employee->id;
        $attendance->date = $request->date;
        
        if (request('check_in')){
            $attendance->check_in = $request->check_in;
        }
        if (request('check_out')){
            $attendance->check_out = $request->check_out;
        }
        $attendance->save();
        return redirect('/attendance')->with("success","Role has been successfully updated .");
    }


    public function destroy(Attendance $attendance){
        $attendance->delete();
        return 'success';
    }

    public function overView(){
        return view('attendance.overview');
    }

    public function overViewTable(){
        $month = request('month');
        $year = request('year');
        if(!$month){
            $month = Carbon::now()->format('m');
        }

        if(!$year){
            $year = Carbon::now()->format('Y');
        }
        
        $start_date = $year . '-' . $month . '-' . '01';
        $end_date = Carbon::parse($start_date)->endOfMonth()->format('Y-m-d');

        $period = new CarbonPeriod($start_date,$end_date);
        $employees = User::orderBy('employee_id')->where('employee_id','like','%'.request('employee_id').'%')->get();
        $attendances = Attendance::whereMonth('date',$month)->whereYear('date',$year)->get();
        $company = Company::first();
        return view('components.attendanceTable',[
            'period'=>$period,
            'employees'=>$employees,
            'attendances' => $attendances,
            'company'=> $company,
            'start_date'=> $start_date,
            'end_date' => $end_date
        ])->render();
    }
}
