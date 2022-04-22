<x-app-layout>
    <x-slot name='title'>
        Edit Machine
    </x-slot>
    
    <div class="row py-4">
        <div class="col-md-6 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="mb-3">
                        <h2>Edit Machine</h2>
                    </div>
                    <form action="/bio-machine/{{$bio_machine->id}}/update" method="POST" enctype="multipart/form-data" >
                    @csrf
                        
                        <x-form.input name="machine_id" label="Machine Id" value="{{$bio_machine->machine_id}}" />
                        
                        <x-form.input name="password" value="{{$bio_machine->password}}" />
                        
                        <x-form.input name="location" type="textarea" value="{{$bio_machine->location}}" />
                    
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