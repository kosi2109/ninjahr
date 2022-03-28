<x-app-layout>
    <x-slot name="title">
        {{$user->name}}
    </x-slot>

    <div class="card my-5 p-3 shadow">
        <div class="d-flex align-items-center">

            <h2 class="py-2 me-3">Employee Details</h2>
            @if ($user->is_present)
            
            <h6>
                <span class="badge bg-success rounded-pill">Present</span>
            </h6>
            @else
            <h6>
                <span class="badge bg-danger rounded-pill">Leave</span>
            </h6>
            @endif
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <div style="width: 100%;">
                    <img style="border-radius: 5px" class="shadow" width="100%" src="{{"/storage/".$user->profile_img}}" alt="{{$user->employee_id}}">
                </div>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="mb-3">Personal Data</h3>
                        <div class="bg-light py-2 px-1 mb-3">
                            <h6 class="text-secondary">Employee Id</h6>
                            <h6 class="text-secondary">{{$user->employee_id}}</h6>
                        </div>
                        <div class="bg-light py-2 px-1 mb-3">
                            <h6  class="text-secondary">Full Name</h6>
                            <h6  class="text-secondary">{{$user->name}}</h6>
                        </div>
                        <div class="bg-light py-2 px-1 mb-3">
                            <h6  class="text-secondary">Nrc Number</h6>
                            <h6  class="text-secondary">{{$user->nrc_number}}</h6>
                        </div>
                        <div class="bg-light py-2 px-1 mb-3">
                            <h6  class="text-secondary">Gender</h6>
                            <h6  class="text-secondary">{{$user->gender}}</h6>
                        </div>
                        <div class="bg-light py-2 px-1 mb-3">
                            <h6  class="text-secondary">Birthdate</h6>
                            <h6  class="text-secondary">{{$user->birthday}}</h6>
                        </div>
                        <div class="bg-light py-2 px-1 mb-3">
                            <h6  class="text-secondary">Department</h6>
                            <h6  class="text-secondary">{{$user->department->title}}</h6>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h3 class="mb-3">Contact</h3>
                        <div class="bg-light py-2 px-1 mb-3">
                            <h6 class="text-secondary">Email</h6>
                            <h6 class="text-secondary">{{$user->email}}</h6>
                        </div>

                        <div class="bg-light py-2 px-1 mb-3">
                            <h6 class="text-secondary">Phone</h6>
                            <h6 class="text-secondary">{{$user->phone}}</h6>
                        </div>

                        <div class="bg-light py-2 px-1 mb-3">
                            <h6  class="text-secondary">Address</h6>
                            <h6 class="text-secondary">{{$user->address}}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <x-slot name="script">
        
    </x-slot>


</x-app-layout>