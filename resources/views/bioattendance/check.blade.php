<x-guest-layout>
    <x-slot name="title">Check In & Out</x-slot>
    <div class="fixed-top mt-3 ml-3 ">
        <button id="logout" class="btn btn-dark">Logout</button>
    </div>
    
    <div class="col-md-4 m-auto card p-5 shadow">
        <form method="POST">
            @csrf
            <h4 class="text-center text-lg mb-3">Check In & Out</h4>
            <div class="d-flex justify-content-center align-items-center">
                {{QrCode::size(200)->generate($qr);}}
            </div>
        </form>

    </div>
    <x-slot name="script"> 

    <script>
        $(document).ready(function(){
            $("#logout").on('click',function(){
                const machine_id = "{{auth('biomateric_attedance')->user()->machine_id}}";
                Swal.fire({
                title: 'Enter Password to log out .',
                html : `<input type='password' class="form-control" id='password' />`,
                confirmButtonText: 'Comfirm',
                showLoaderOnConfirm: true,
            }).then((result)=>{
                if (result.isConfirmed) {
                    $.ajax({
                        method: "POST",
                        url: `/password-check`,
                        data: {_token:"{{ csrf_token() }}",password:$('#password').val(),machine_id:machine_id},
                    }).done(function (data) {
                        
                        if (data.error) {
                            Swal.fire("Error!", data.error, "error");
                        } else {
                            window.location.replace("/")
                        }

                    });
                }
            })
            })  
        })

        
    </script>
    </x-slot>

</x-guest-layout>
