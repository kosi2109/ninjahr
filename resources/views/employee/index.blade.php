<x-app-layout>
    
    <x-slot name="title">
        Employee
    </x-slot>
    <div class="py-4">
    @can('create_employee')
    <div class="mb-3">
        <a href="/employee/create" class="btn btn-sm btn-primary"><i class="fa-solid fa-circle-plus"></i> Create Employee</a>
    </div>
    @endcan
    <div class="card px-2 px-md-5 py-3 shadow">
        <h2>All Employee</h2>
        <table class="table DataTable display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th></th>
                    <th>Employee Id</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>Role</th>
                    <th>Present</th>
                    <th class="no-sort">Action</th>
                    <th>Update At</th>
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
                    ajax: '/employee/database/ssd',
                    method: "GET",
                    columns: [
                        { data: 'profile_img', name: 'profile_img' },
                        { data: 'employee_id', name: 'employee_id' },
                        { data: 'email', name: 'email' },
                        { data: 'department_name', name: 'department_name' },
                        { data: 'role_name', name: 'role_name' },
                        { data: 'is_present', name: 'is_present' },
                        { data: 'action', name: 'action' },
                        { data: 'updated_at', name: 'updated_at' },
                    ],
                    order: [[ 7, 'desc' ]],
                    columnDefs: [
                            {
                                "targets": [ 7 ],
                                "visible": false,
                                "searchable": false
                            },
                            { orderable: false, "targets": [6,5] },

                    ],
                    
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
                            url: `employee/${id}/delete`,
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