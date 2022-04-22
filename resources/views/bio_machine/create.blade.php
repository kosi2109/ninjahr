<x-app-layout>
    <x-slot name='title'>
        Create Machine
    </x-slot>
    
    <div class="row py-4">
        <div class="col-md-6 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="mb-3">
                        <h2>Create Machine</h2>
                    </div>
                    <form action="/bio-machine/store" method="POST" enctype="multipart/form-data" >
                    @csrf
                        <x-form.input name="machine_id" label="Machine Id" />
                        
                        <x-form.input name="password" type="password" />
                        
                        <x-form.input name="location" type="textarea" />
                        
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