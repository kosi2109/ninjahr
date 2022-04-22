<x-app-layout>
    <x-slot name='title' >
        Project|{{$project->title}}
    </x-slot>
    
<div class="container py-4">    
    <div class="row mb-3">
        <div class="col-md-8">
            <div class="row">
                <div class="col-12 mb-2">
                    <div class="card shadow p-3 d-flex flex-col ">
                        <h2 class="fs-1">{{$project->title}}</h2>
                        <h3 class="fs-5">Started Date : {{$project->start_date}}</h3>
                        <h3 class="fs-5">Deadline : {{$project->deadline}}</h3>
                        <p class="p-3">{{$project->description}}</p>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="row">
                <div class="col-12 mb-2">
                    <div class="card shadow p-3">
                        <h5>Leaders</h5>
                        <div class="row">
                            @foreach ($project->leaders as $leader)
                                <div class="col-3">
                                    <img src="{{$leader->profile_img}}" class="rounded-circle" style="width: 50px;height:50px" alt="img">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-2">
                    <div class="card shadow p-3">
                        <h5>Members</h5>
                        <div class="row">
                            @foreach ($project->members as $member)
                                <div class="col-3">
                                    <img src="{{$member->profile_img}}" class="rounded-circle" style="width: 50px;height:50px" alt="img">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-2">
                    <div class="card shadow p-3">
                        <h5>Images</h5>
                        <div class="row" id="images">
                            @foreach ($project->images as $image)
                                <div class="col-3">
                                    <img style="cursor: pointer" src="{{$image}}" alt="img" width="100%">
                                </div>
                            @endforeach
                        </div>
                    </div>   
                </div>
                <div class="col-12 mb-2">
                    <div class="card shadow p-3">
                        <h5>Files</h5>
                        <div class="row">
                            @foreach ($project->files as $file)
                                <div class="col-3">
                                    <a href="{{$file}}" target="_blank">
                                        <div class="border text-center p-2 rounded-2 text-primary fs-3">
                                            <i class="fa-solid fa-file-pdf"></i>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
    </div>

    <h5>Tasks</h5>
    <div class="row" id="tasks">
        
    </div>
</div>
    

    <x-slot name='script' >
        <script>
            var leaders = @json($project->leaders);
            var members = @json($project->members);
            var pjId = {{$project->id}}
        </script>
        <script src="js/projectShow.js"></script>
    </x-slot>
</x-app-layout>