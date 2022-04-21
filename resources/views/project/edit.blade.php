<x-app-layout>
    <x-slot name='title'>
        Edit Project
    </x-slot>
    
    <div class="row py-4">
        <div class="col-md-6 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="mb-3">
                        <h2>Edit Project</h2>
                    </div>
                    
                    <form action="/project/{{$project->id}}/update" method="POST" enctype="multipart/form-data" >
                    @csrf
                        
                    <x-form.input name="title" value="{{$project->title}}" />
                        
                    <div class="mb-3">
                        <label for="description"  class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="description" cols="30" rows="5">{{$project->description}}</textarea>
                    </div>
                    
                    <x-form.input type="date" name="start_date" label="Start Date" value="{{$project->start_date}}" />

                    <x-form.input type="date" name="deadline" label="Deadline" value="{{$project->deadline}}" />
                
                    <div class="mb-3">
                        <label class="form-label" for="images">Images</label>
                        <input id="images" type="file" class="form-control" name="images[]" multiple accept=".png, .jpg, .jpeg" >
                    </div>

                    <div class="row mb-3">
                        @foreach ($project->images as $image)
                        <div class="col-md-3">
                            <img src="/storage/{{$image}}" width="100%" alt="some" />
                        </div>
                        @endforeach
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="files">Files</label>
                        <input id="files" type="file" class="form-control" name="files[]" multiple accept="application/pdf" >
                    </div>

                    <div class="row mb-3">
                        @foreach ($project->files as $file)
                        <div class="col-md-2">
                            <a href="/storage/{{$file}}" target="_black" class="bg-primary">
                                <div class="border text-center p-2 rounded-2 text-primary fs-3">
                                    <i class="fa-solid fa-file-pdf"></i>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="priority">Priority</label>
                        <select name="priority" id="priority" class="form-control">
                            <option {{$project->priority == 'low' ? 'selected' : ""}} value="low">Low</option>
                            <option {{$project->priority == 'middle' ? 'selected' : ""}} value="middle">Middle</option>
                            <option {{$project->priority == 'high' ? 'selected' : ""}} value="high">High</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="pending">Pending</option>
                            <option value="in_progress">Inprogress</option>
                            <option value="complete">Complete</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="status">Leaders</label>
                        <select name="leaders[]" id="leaders" class="form-control" multiple>
                            @foreach ($users as $user)
                                @if (in_array($user->id,$project->leaders->pluck('id')->toArray()))
                        
                                <option selected value="{{$user->id}}">{{$user->name}}</option>    
                                @else
                                <option value="{{$user->id}}">{{$user->name}}</option>    
                                    
                                @endif
                            @endforeach        
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="status">Members</label>
                        <select name="members[]" id="members" class="form-control" multiple>
                            @foreach ($users as $user)
                                @if (in_array($user->id,$project->members->pluck('id')->toArray()))
                            
                                <option selected value="{{$user->id}}">{{$user->name}}</option>    
                                @else
                                <option value="{{$user->id}}">{{$user->name}}</option>    
                                    
                                @endif   
                            @endforeach        
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
           $(document).ready(function() {
                $('#leaders').select2({
                    theme: 'bootstrap-5'
                });

                $('#members').select2({
                    theme: 'bootstrap-5'
                });
            });
       </script>
    </x-slot>
</x-app-layout>