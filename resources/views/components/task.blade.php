@props(['task'])

<div data-id="{{$task->id}}" class="d-flex flex-column mb-3 border border-dark p-2 rounded-2" style="user-select: none;">
    <div class="d-flex justify-content-between align-items-center mb-1">
        <h5>{{$task->title}}</h5>
        <div class="d-flex">
            <button data-task="{{json_encode($task)}}" data-members="{{json_encode($task->members->pluck('id'))}}" class="edit_task_btn mx-1 text-center d-flex justify-content-center aligh-items-center text-warning" style="background-color: inherit;outline: none ; border:none"><i class="fa-solid fa-pen-to-square" style="font-size: 15px"></i></button>
            <button data-id="{{$task->id}}" class="delete_task_btn mx-1 text-center d-flex justify-content-center aligh-items-center text-danger" style="background-color: inherit;outline: none ; border:none"><i class="fa-solid fa-trash" style="font-size: 15px"></i></button>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex flex-column align-items-start">
            @if ($task->priority == 'high')
                <span class="badge me-1 rounded-pill bg-danger">High</span>
            @elseif($task->priority == 'middle') 
                <span class="badge me-1 rounded-pill bg-warning">Middle</span>
            @else
                <span class="badge me-1 rounded-pill bg-info">Low</span>
            @endif
            
            <h6 class="p-0 m-0 fs-6 mt-1">{{$task->start_date}}</h6>
        </div>
        <div class="d-flex align-items-center">
            @foreach ($task->members as $member)
            <img src="{{$member->profile_img}}" alt="img" class="rounded-circle bg-danger" style="width: 20px;height:20px;margin-left:-5px" />
            @endforeach
        </div>
    </div>
</div>