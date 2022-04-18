@props(['title','project'])

<div class="card">
    <div class="card-header">
        {{$title}}
     
    </div>
    <div class="card-body d-flex flex-column">
        <div id="{{strtolower($title)}}_board" style="min-height: 100px;">
            @foreach (collect($project->tasks)->where('status',strtolower($title))->sortBy('serial') as $task)
            <x-task :task="$task" />
            @endforeach
        </div>
        <button id="{{strtolower($title)}}" class="btn btn-outline-dark">Add Task</button>
    </div>
</div>
