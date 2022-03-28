<x-app-layout>
    <x-slot name='title'>
        Create Department
    </x-slot>
    
    <div class="row my-5">
        <div class="col-md-6 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="mb-3">
                        <h2>Create Department</h2>
                    </div>
                    <form action="/department/store" method="POST" enctype="multipart/form-data" >
                    @csrf
                        <x-form.input name="title" />
                    
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Create</button>
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
                if (img.files.length > 0){
                    preview_img.innerHTML = `<img src=${URL.createObjectURL(event.target.files[0])} alt="preview" style="max-width:100%;height:auto;" />`
                }
            })

        </script>
    </x-slot>
</x-app-layout>