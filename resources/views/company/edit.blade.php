<x-app-layout>
    <x-slot name='title'>
        Edit Company
    </x-slot>
    
    <div class="row my-5">
        <div class="col-md-6 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="mb-3">
                        <h2>Edit Company</h2>
                    </div>
                    <form action="/company/1/update" method="POST" enctype="multipart/form-data" >
                    @csrf
                        <x-form.input name="company_name" value="{{$company->company_name}}" />
                        
                        <x-form.input name="company_phone" value="{{$company->company_phone}}" />
                        
                        <x-form.input name="company_email" value="{{$company->company_email}}" />
                        
                        <x-form.input type='time' name="office_start_time" value="{{$company->office_start_time}}" />
                        
                        <x-form.input type='time' name="office_end_time" value="{{$company->office_end_time}}" />
                        
                        <x-form.input type='time' name="break_start_time" value="{{$company->break_start_time}}" />
                        
                        <x-form.input type='time' name="break_end_time" value="{{$company->break_end_time}}" />
                        
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