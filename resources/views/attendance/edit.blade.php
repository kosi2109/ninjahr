<x-app-layout>
    <x-slot name='title'>
        Edit Attendance
    </x-slot>
    
    <div class="row my-5">
        <div class="col-md-6 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="mb-3">
                        <h2>Edit Attendance</h2>
                    </div>
                    <form action="/attendance/{{$attendance->id}}/update" method="POST" enctype="multipart/form-data" >
                    @csrf
                        <x-form.input name="employee_id" value="{{$attendance->user->employee_id}}" />
                        <x-form.input name="check_in" type="time" value="{{$attendance->check_in}}" />
                        <x-form.input name="check_out" type="time" value="{{$attendance->check_out}}" />
                        <x-form.input name="date" type="date" value="{{$attendance->date}}" />
                        
                    
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Edit</button>
                        </div>
                        <div>
                            @if(session("error"))
                                <h6 class="my-2 text-danger">
                                    {{ session("error") }}
                                </h6>
                            @endif
                            @if($errors->any())
                                {!! implode('', $errors->all('<li class="text-danger">:message</li>')) !!}
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <x-slot name='script'>
       
    </x-slot>
</x-app-layout>