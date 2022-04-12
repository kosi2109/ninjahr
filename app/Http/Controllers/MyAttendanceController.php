<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Company;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MyAttendanceController extends Controller
{
    public function overView(){
        return view('my-attendance.overview');
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
        
        $start_date = $year . '-' . $month . '-01';
        $end_date = Carbon::parse($start_date)->endOfMonth()->format('Y-m-d');

        $period = new CarbonPeriod($start_date,$end_date);
        $employees = User::where('id',auth()->id())->get();
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

    public function ssd()
    {   
        $month = request('month');
        $year = request('year');
        if(!$month){
            $month = Carbon::now()->format('m');
        }

        if(!$year){
            $year = Carbon::now()->format('Y');
        }

        $attendance = Attendance::with('user')->where('user_id',auth()->id())->whereMonth('date',$month)->whereYear('date',$year);
        return DataTables::of($attendance)
        ->editColumn('user_id',function ($each){
            return $each->user ? $each->user->name : '-';
        })
        ->rawColumns([])
        ->make(true);
    }
}
