@if ((int)count($attendances) > 0)
<table class="table table-bordered">
    <h5>Data from {{$start_date}} to {{$end_date}}</h5>
    <thead class="text-center">
        <th>Employee</th>
        @foreach ($period as $p)
            @if ($p->format('D') == 'Sun' || $p->format('D') == 'Sat')
            <th class="alert-danger">{{$p->format('d')}} <br> {{$p->format('D')}}</th>
            @else
            <th>{{$p->format('d')}} <br> {{$p->format('D')}}</th>
            @endif
 
        @endforeach
    </thead>
    <tbody>
            @foreach ($employees as $employee)
                <tr>
                    <td>{{$employee->employee_id}}</td>
                    @foreach ($period as $p)
                        
                        @php
                        $mornee = '';
                        $even = '';
                        $attendance = collect($attendances)->where('user_id',$employee->id)->where('date',$p->format('Y-m-d'))->first();
                            if($p->format('Y-m-d') > now()->format('Y-m-d')){
                                $mornee = '';
                                $even = '';
                            }elseif($p->format('D') == 'Sun' || $p->format('D') == 'Sat'){
                                $mornee = '';
                                $even = "<span class='text-danger'>off</span>";
                            }elseif($attendance){
                                if($attendance->check_out < $company->break_start_time){
                                    $mornee = '<i class="fa-solid fa-circle-exclamation text-warning"></i>';;
                                }elseif($attendance->check_in <= $company->office_start_time){
                                    $mornee = '<i class="fa-solid fa-circle-check text-success"></i>';
                                }elseif($attendance->check_in > $company->office_start_time && $attendance->check_in < $company->break_start_time){
                                    $mornee = '<i class="fa-solid fa-person-running text-warning"></i>';
                                }else{
                                    $mornee = '<i class="fa-solid fa-circle-xmark text-danger"></i>';
                                }

                                if($attendance->check_out < $company->break_end_time){
                                    $even = '<i class="fa-solid fa-circle-xmark text-danger"></i>';
                                }elseif($attendance->check_in <= $company->break_end_time && $attendance->check_out >= $company->office_end_time){
                                    $even = '<i class="fa-solid fa-circle-check text-success"></i>';
                                }elseif($attendance->check_in > $company->break_end_time && $attendance->check_in < $company->office_end_time){
                                    $even = '<i class="fa-solid fa-person-running text-warning"></i>';
                                }elseif($attendance->check_in < $company->break_end_time && $attendance->check_out < $company->office_end_time){
                                    $even = '<i class="fa-solid fa-circle-exclamation text-warning"></i>';
                                }else{
                                    $even = '<i class="fa-solid fa-circle-xmark text-danger"></i>';
                                }
                            }else{
                                $mornee = '<i class="fa-solid fa-circle-xmark text-danger"></i>';
                            }
                        @endphp
                        <td class="text-center">
                        {!!$mornee!!}
                        {!!$even!!}
                        </td>  
                        
                    @endforeach
                    
                </tr>
                
            @endforeach

    </tbody>
</table>
@else
    <div class="text-center">
        <h5>No Data font for This Date</h5>
    </div>
@endif