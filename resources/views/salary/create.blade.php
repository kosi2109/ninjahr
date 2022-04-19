<x-app-layout>
    <x-slot name='title'>
        Create Salary
    </x-slot>
    
    <div class="row py-4">
        <div class="col-md-6 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="mb-3">
                        <h2>Create Salary</h2>
                    </div>
                    <form action="/salary/store" method="POST" enctype="multipart/form-data" >
                    @csrf
                        <x-form.input name="employee_id" label="Employee Id" />
                        
                        <x-form.input name="month" label="Month (2022-01)" />
                        
                        <x-form.input name="ammount" type="number" label="Ammount (MMK)" />

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
        <script>
        
        </script>
    </x-slot>
</x-app-layout>