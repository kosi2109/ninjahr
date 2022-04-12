<x-app-layout>
    <x-slot name='title'>
        Create Attendance
    </x-slot>
    
    <div class="row my-5">
        <div class="col-md-6 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="mb-3">
                        <h2>Create Attendance</h2>
                    </div>
                    <form action="/attendance/store" method="POST">
                    @csrf
                        <x-form.input name="employee_id" />
                        
                        <x-form.input name="check_in" type="time" />
                        
                        <x-form.input name="check_out" type="time" />
                        
                        <x-form.input name="date" type="date" />
                        


                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Create</button>
                            <input name="add_more" type="submit" class="btn btn-primary" value="Create & Add More" >
                        </div>
                        <div>
                            @if(session("success"))
                                <h6 class="my-2 text-success">
                                    {{ session("success") }}
                                </h6>
                            @endif
                            

                            @if(session("error"))
                                <h6 class="my-2 text-danger">
                                    {{ session("error") }}
                                </h6>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <x-slot name='script'>
        <script>


        </script>
    </x-slot>
</x-app-layout>