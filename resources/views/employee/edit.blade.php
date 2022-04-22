<x-app-layout>
    <x-slot name='title'>
        Edit Employee
    </x-slot>
    
    <div class="row py-4">
        <div class="col-md-6 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="mb-3">
                        <h2>Edit Employee</h2>
                    </div>
                    <form action="/employee/{{$employee->id}}/update" method="POST" enctype="multipart/form-data" >
                    @csrf
                        <x-form.input name="employee_id" value="{{$employee->employee_id}}" />
                        
                        <x-form.input name="name" value="{{$employee->name}}" />

                        <x-form.input name="phone" value="{{$employee->phone}}" />

                        <x-form.input name="email" value="{{$employee->email}}" type="email" />

                        <x-form.input name="nrc_number" value="{{$employee->nrc_number}}" />
                        
                        <x-form.input name="password" type="password" />

                        <x-form.input name="profile_img" type="file" value="{{$employee->profile_img}}" />

                        <div id="preview_img" class="d-flex justify-content-center align-items-center mb-3" style="width: 100%">
                            <img src="{{$employee->profile_img}}" alt="preview" style="max-width:100%;height:auto;">
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select name="gender" id="gender" class="form-select" aria-label="Default select example">
                                <option selected>Gender</option>
                                @if (old('gender'))
                                <option {{ "male" == old('gender') ?'selected' : ''}} value="male">Male</option>
                                <option {{ "female" == old('gender') ?'selected' : ''}} value="female">Female</option>
                                    
                                @else
                                <option {{ "male" == $employee->gender ?'selected' : ''}} value="male">Male</option>
                                <option {{ "female" == $employee->gender ?'selected' : ''}} value="female">Female</option>
                                @endif
                            </select>
                        </div>
                        
                        <x-form.input name="birthday" value="{{$employee->birthday}}" type="date" />
                            
                        <x-form.input name="address" value="{{$employee->address}}" type="textarea" />
                        
                        
                        <div class="mb-3">
                            <label for="department" class="form-label">Department</label>
                            <select name="department_id" id="department" class="form-select" aria-label="Default select example">
                                
                                @foreach ($departments as $department)
                                    @if (old('department_id'))
                                    <option {{ $department->id == old('department_id') ?'selected' : ''}} value="{{$department->id}}">{{$department->title}}</option>
                        
                                    @else
                                        
                                    <option {{ $employee->department->id == $department->id ?'selected' : ''}} value="{{$department->id}}">{{$department->title}}</option>
                    
                                    @endif
                                @endforeach
                                
                              </select>
                            </div>

                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select name="role_id[]" id="role" class="form-select" aria-label="Default select example" multiple>
                                    @foreach ($roles as $role)
                                        <option {{ in_array($role->id,$employee->roles->pluck('id')->toArray()) ? 'selected' : ''}} value="{{$role->id}}">{{$role->name}}</option>
                                    @endforeach    
                                </select>
                            </div>
                        
                        <x-form.input name="date_of_join" value="{{$employee->date_of_join}}" type="date" />


                        <div class="mb-3">
                            <label for="is_present" class="form-label">Is Present</label>
                            <select name="is_present" id="is_present" class="form-select" aria-label="Default select example">
                                <option {{ "1" == old('is_present') ?'selected' : ''}} value="1">Present</option>
                                <option {{ "0" == old('is_present') ?'selected' : ''}} value="0">Leaft</option>
                            </select>
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
        <script>
            const img = document.getElementById('profile_img')
            const preview_img = document.getElementById('preview_img')
            img.addEventListener('change',function(){
                preview_img.innerHTML = ""
                if (img.files.length > 0){
                    preview_img.innerHTML = `<img src=${URL.createObjectURL(event.target.files[0])} alt="preview" style="max-width:100%;height:auto;" />`
                }
            })
            $(document).ready(function() {
                $('#role').select2({
                    theme: 'bootstrap-5'
                });
            });
        </script>
    </x-slot>
</x-app-layout>