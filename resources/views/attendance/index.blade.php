<x-app-layout>
    
    <x-slot name="title">
        Attendances
    </x-slot>
    <div class="py-4">
        @can('create_employee')
        <div class="mb-3">
            <a href="/attendance/create" class="btn btn-sm btn-primary"><i class="fa-solid fa-circle-plus"></i> Create Attendance</a>
        </div>
        @endcan
    
    <div class="card px-2 px-md-5 py-3 shadow">
        <h2>Attendances</h2>
        <table class="table DataTable display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                    <th>Date</th>
                    <th class="no-sort">Action</th>
                </tr>
            </thead>
        </table>
        @if(session("success"))
            <h6 class="my-2 text-success">
                {{ session("success") }}
            </h6>
        @endif
    </div>


    <x-slot name="script">
        <script>
            $(document).ready(
            $(function() {
                var table = $('.DataTable').DataTable({
                    ajax: '/attendance/database/ssd',
                    method: "GET",
                    columns: [
                        { data: 'user_id', name: 'user_id' },
                        { data: 'check_in', name: 'check_in' },
                        { data: 'check_out', name: 'check_out' },
                        { data: 'date', name: 'date' },
                        { data: 'action', name: 'action' },
                    ],
                    order: [[ 0, 'desc' ]],
                    
                });

                $(document).on('click','.delete',function(e){
                e.preventDefault();
                var id = $(this).data('id')
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: "DELETE",
                            url: `attendance/${id}/delete`,
                            })
                            .done(function() {
                                table.ajax.reload();
                                Swal.fire(
                                'Deleted!',
                                'User has been deleted.',
                                'success'
                                )
                            });
                    }
                })
            })
            }));

            
            
        </script>
    </x-slot>
</x-app-layout>