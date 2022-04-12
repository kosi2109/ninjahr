<x-app-layout>
    <x-slot name="title">
        {{$user->name}}
    </x-slot>

    <div class="position-relative card my-5 p-3 shadow">
        @if (auth()->user()->id == $user->id)
        <div class="position-absolute" style="right:2%" >
            <form action="/logout" method="POST">
                @csrf
                <button style="width: 30px;height: 30px;" class="btn-dark rounded-circle"><i class="fa-solid fa-right-from-bracket"></i></button>
            </form>
        </div>
        @endif
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
                            <h6 class="text-secondary">Address</h6>
                            <h6 class="text-secondary">{{$user->address}}</h6>
                        </div>
                        
                        <div class="bg-light py-2 px-1 mb-3 relative">
                            <h6 class="text-secondary">Biomatric Regeration</h6>
                            <p class="text-secondary fs-6">Click Icon to Delete</p>
                            <button id="biomatric-register" class="m-0 mb-2 p-4 rounded-2 bg-white border-dark relative d-flex flex-column justify-content-center align-items-center" style="width:60px;height:60px;position:relative">
                                <i class="fa-solid fa-fingerprint fs-2"></i>
                                <i class="fa-solid fa-circle-plus" style="position: absolute;right:5%;bottom:5%"></i>
                            </button>
                            <div class="row" id="biodata">
                                
                            </div>
                            

                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <x-slot name="script">
        <!-- Registering credentials -->
        <script>
            bioData()
            function bioData(){
                $.ajax({
                    url : 'profile/bio-data',
                    type : 'GET',
                    success : function(res){
                        $('#biodata').html(res)
                        
                    }
                })
            }

            const register = (event) => {
                new Larapass({
                    register: 'webauthn/register',
                    registerOptions: 'webauthn/register/options'
                }).register()
                .then(response => {
                    
                    bioData()
                })
                .catch(response => {
                    Swal.fire(
                    'Error',
                    'Something wroung . Please Try again .',
                    'error'
                    )})
            }

            document.getElementById('biomatric-register').addEventListener('click', register)



            $(document).on('click','.delete',function(e){
                e.preventDefault();
                var id = $(this).data('id')
                Swal.fire({
                    title: 'Are you sure to Delete ?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Delete'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: "DELETE",
                            url: `biodata/${id}/delete`,
                            })
                            .done(function() {
                                bioData()
                                Swal.fire(
                                'Deleted!',
                                'User has been deleted.',
                                'success'
                                )
                            });
                    }
                })
            })
        </script>
    </x-slot>


</x-app-layout>