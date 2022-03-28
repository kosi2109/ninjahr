<x-app-layout>
    <x-slot name='title'>
        Edit Permission
    </x-slot>
    
    <div class="row my-5">
        <div class="col-md-6 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="mb-3">
                        <h2>Edit Permission</h2>
                    </div>
                    <form action="/permission/{{$permission->id}}/update" method="POST" enctype="multipart/form-data" >
                    @csrf
                        <x-form.input name="name" value="{{$permission->name}}" />
                        
                    
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