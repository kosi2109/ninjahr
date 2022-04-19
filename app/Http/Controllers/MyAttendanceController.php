<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Company;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
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


    public function payrollTable(){
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

        $days_of_month = Carbon::parse($start_date)->daysInMonth;
        $working_days = Carbon::parse($start_date)->diffInDaysFiltered(function (Carbon $data){
            return $data->isWeekday();
        },Carbon::parse($end_date)->addDays(1));


        $period = new CarbonPeriod($start_date,$end_date);
        $employees = User::orderBy('employee_id')->where('employee_id',auth()->user()->employee_id)->get();
        $attendances = Attendance::whereMonth('date',$month)->whereYear('date',$year)->get();
        $company = Company::first();
        
        return view('components.payrollTable',[
            'period'=>$period,
            'employees'=>$employees,
            'attendances' => $attendances,
            'company'=> $company,
            'start_date'=> $start_date,
            'end_date' => $end_date,
            'days_of_month' => $days_of_month,
            'working_days' => $working_days
        ])->render();
    }
}
