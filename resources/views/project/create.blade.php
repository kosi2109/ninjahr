<x-app-layout>
    <x-slot name='title'>
        Create Project
    </x-slot>
    
    <div class="row py-4">
        <div class="col-md-6 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="mb-3">
                        <h2>Create Project</h2>
                    </div>
                    <form action="/project/store" method="POST" enctype="multipart/form-data" >
                    @csrf
                        <x-form.input name="title"/>
                        
                        <x-form.input name="description" type="textarea" />
                        
                        <x-form.input type="date" name="start_date" label="Start Date" />

                        <x-form.input type="date" name="deadline" label="Deadline" />
                    
                        <div class="mb-3">
                            <label class="form-label" for="images">Images</label>
                            <input id="images" type="file" class="form-control" name="images[]" multiple accept=".png, .jpg, .jpeg" >
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="files">Files</label>
                            <input id="files" type="file" class="form-control" name="files[]" multiple accept="application/pdf" >
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="priority">Priority</label>
                            <select name="priority" id="priority" class="form-control">
                                <option value="low">Low</option>
                                <option value="middle">Middle</option>
                                <option value="high">High</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="pending">Pending</option>
                                <option value="in_progess">Inprogress</option>
                                <option value="complete">Complete</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="status">Leaders</label>
                            <select name="leaders[]" id="leaders" class="form-control" multiple>
                                @foreach ($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>    
                                @endforeach        
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="status">Members</label>
                            <select name="members[]" id="members" class="form-control" multiple>
                                @foreach ($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>    
                                @endforeach        
                            </select>
                        </div>

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