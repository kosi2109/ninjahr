<x-app-layout>
    <x-slot name='title'>
        Edit Salary
    </x-slot>
    
    <div class="row py-4">
        <div class="col-md-6 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="mb-3">
                        <h2>Edit Salary</h2>
                    </div>
                    <form action="/salary/{{$salary->id}}/update" method="POST" enctype="multipart/form-data" >
                    @csrf
                        
                        <x-form.input name="employee_id" label="Employee Id" value="{{$user->employee_id}}" />
                        
                        <x-form.input name="month" label="Month (2022-01)" value="{{$salary->month}}" />
                        
                        <x-form.input name="ammount" type="number" label="Ammount (MMK)" value="{{$salary->ammount}}" />
                    
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Edit</button>
                        </div>
                        <div>
                            <ul>
                                @if($errors->any())
                                    {!! implode('', $errors->all('<li class="text-danger">:message</li>')) !!}
                                @endif
                                
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <x-slot name='script'>
       
    </x-slot>
</x-app-layout>