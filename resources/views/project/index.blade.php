<x-app-layout>
    
    <x-slot name="title">
        Projects
    </x-slot>
    <div class="py-4">
    @can('create_project')
    <div class="mb-3">
        <a href="/project/create" class="btn btn-sm btn-primary"><i class="fa-solid fa-circle-plus"></i> Create Project</a>
    </div>
    @endcan
    <div class="card px-2 px-md-5 py-3 shadow table-responsive">
        <h2>Projects</h2>
        <table class="table DataTable display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Leaders</th>
                    <th>Members</th>
                    <th>Start Date</th>
                    <th>Deadline</th>
                    <th>Priority</th>
                    <th>Status</th>

                    <th class="no-sort">Action</th>
                    <th>updated_at</th>
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
                    ajax: '/project/database/ssd',
                    method: "GET",
                    columns: [
                        { data: 'title', name: 'title' ,class : 'text-wrap' },
                        { data: 'description', name: 'description' , class : 'text-wrap' },
                        { data: 'leaders', name: 'leaders',class : 'text-center'},
                        { data: 'members', name: 'members', class : 'text-center'},
                        { data: 'start_date', name: 'start_date' },
                        { data: 'deadline', name: 'deadline'  },
                        { data: 'priority', name: 'priority' , class : 'text-center' },
                        { data: 'status', name: 'status' ,class : 'text-center' },
                        { data: 'action', name: 'action' },
                        { data: 'updated_at', name: 'updated_at' },
                    ],
                    order: [[ 9, 'desc' ]],

                    columnDefs: [
                            {
                                "targets": [ 9 ],
                                "visible": false,
                                "searchable": false
                            },
                            { orderable: false, "targets": [2,3,8] },

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
                            url: `project/${id}/delete`,
                            })
                            .done(function() {
                                table.ajax.reload();
                                Swal.fire(
                                'Deleted!',
                                'Project has been deleted.',
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