<x-app-layout>
    <x-slot name='title'>
        Edit Role
    </x-slot>

    <div class="row my-5">
        <div class="col-md-6 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="mb-3">
                        <h2>Edit Department</h2>
                    </div>
                    <form action="/role/{{$role->id}}/update" method="POST" enctype="multipart/form-data" >
                    @csrf
                        <x-form.input name="name" value="{{$role->name}}" />
                        
                            <div class="mb-3">
                                <label class="form-label">Permissions</label>
                                <div class="row">
                                    @foreach ($permissions as $permission)
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input name="permissions[]" class="form-check-input" type="checkbox" value="{{$permission->name}}" id="checkbox_{{$permission->id}}" {{in_array($permission->name,$role->permissions->pluck('name')->toArray()) ? 'checked' : ''}} />
                                            <label class="form-check-label" for="checkbox_{{$permission->id}}">
                                                {{$permission->name}}
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                    
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