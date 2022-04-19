@if ((int)count($attendances) > 0)
<table class="table table-bordered">
    <h4 class="text-muted">Payroll</h4>
    <h5>Data from {{$start_date}} to {{$end_date}}</h5>
    <thead class="text-center">
        <th>Employee</th>
        <th>Roll</th>
        <th>Days of month</th>
        <th>Working days</th>
        <th>Off days</th>
        <th>Attendance days</th>
        <th>leave</th>
        <th>Per Day(MMK)</th>
        <th>Net Total</th>
    </thead>
    <tbody>
            @foreach ($employees as $employee)
                <tr>
                    <td>{{$employee->employee_id}}</td>
                    <td class="text-center">{{implode(',',$employee->roles->pluck('name')->toArray())}}</td>
                    <td class="text-center">{{$days_of_month}}</td>
                    <td class="text-center">{{$working_days}}</td>
                    <td class="text-center">{{$days_of_month - $working_days}}</td>
                    @php
                        $attend = 0;
                        $leave = 0;
                        
                    @endphp
                    @foreach ($period as $p)
                        @php
                        $attendance = collect($attendances)->where('user_id',$employee->id)->where('date',$p->format('Y-m-d'))->first();
                            if($p->format('Y-m-d') >= now()->format('Y-m-d')){
                                
                            }elseif($p->format('D') == 'Sun' || $p->format('D') == 'Sat'){
                                
                            }elseif($attendance){
                                if($p->format('Y-m-d') != now()->format('Y-m-d')){
                                    if($attendance->check_out < $company->break_start_time){
                                        $attend  = $attend + 0.5;
                                    }elseif($attendance->check_in <= $company->office_start_time){
                                        $attend = $attend +0.5;
                                    }elseif($attendance->check_in > $company->office_start_time && $attendance->check_in < $company->break_start_time){
                                        $attend = $attend +0.5;
                                    }else{
                                        $leave = $leave +0.5;
                                    }

                                    if($attendance->check_out < $company->break_end_time){
                                        $leave = $leave +0.5;
                                    }elseif($attendance->check_in <= $company->break_end_time && $attendance->check_out >= $company->office_end_time){
                                        $attend = $attend +0.5;
                                    }elseif($attendance->check_in > $company->break_end_time && $attendance->check_in < $company->office_end_time){
                                        $attend = $attend +0.5;
                                    }elseif($attendance->check_in < $company->break_end_time && $attendance->check_out < $company->office_end_time){
                                        $attend = $attend +0.5;
                                    }else{
                                        $leave = $leave +0.5;
                                    }
                                }else{
                                    if(now()->format('H:m') > $company->office_start_time ){
                                        if($attendance->check_out < $company->break_start_time){
                                            $attend  = $attend + 0.5;
                                        }elseif($attendance->check_in <= $company->office_start_time){
                                            $attend = $attend +0.5;
                                        }elseif($attendance->check_in > $company->office_start_time && $attendance->check_in < $company->break_start_time){
                                            $attend = $attend +0.5;
                                        }else{
                                            $leave = $leave +0.5;
                                        }
                                    }elseif(now()->format('H:m') > $company->break_end_time){
                                        if($attendance->check_out < $company->break_end_time){
                                            $leave = $leave +0.5;
                                        }elseif($attendance->check_in <= $company->break_end_time && $attendance->check_out >= $company->office_end_time){
                                            $attend = $attend +0.5;
                                        }elseif($attendance->check_in > $company->break_end_time && $attendance->check_in < $company->office_end_time){
                                            $attend = $attend +0.5;
                                        }elseif($attendance->check_in < $company->break_end_time && $attendance->check_out < $company->office_end_time){
                                            $attend = $attend +0.5;
                                        }else{
                                            $leave = $leave +0.5;
                                        }
                                    }
                                }
                            }else{
                                $leave = $leave +1;
                            }
                        @endphp
                        
                        
                    @endforeach
                    <td class="text-center">
                        {!!$attend!!}
                    </td>  

                    <td class="text-center">
                        {!!$leave!!}
                    </td> 

                    <td class="text-center">
                        @php
                            $da = explode('-',$start_date);
                            $at = collect($employee->salary)->where('month',$da[0] .'-'. $da[1])->first();
                            if($at){
                                $per_day = $at->ammount/$working_days;
                            }else{
                                $per_day = 0;
                            }
                        @endphp
                        {{round($per_day)}}
                        
                    </td> 

                    <td>
                        {{round($per_day * $attend)}}
                    </td>
                </tr>
                
            @endforeach

    </tbody>
</table>
@else
    <div class="text-center">
        <h5>No Data font for This Date</h5>
    </div>
@endif