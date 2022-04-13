<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\payroll;
use App\Models\BiomatericAttedance;
use App\Models\Company;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class PayrollController extends Controller
{
    public function payroll(){
        return view('payroll.overview');
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
        $employees = User::orderBy('employee_id')->where('employee_id','like','%'.request('employee_id').'%')->get();
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
