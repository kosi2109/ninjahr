<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;

class TaskController extends Controller
{
    public function store(){
        $project = Project::where('id',request('project_id'))->firstOrFail();

        $task = new Task();

        $task->project_id = $project->id;
        $task->title = request('title');
        $task->description = request('description');
        $task->start_date = request('start_date');
        $task->deadline = request('deadline');
        $task->priority = request('priority');
        $task->status = request('status');
        
        $task->save();
        $task->members()->sync(request('members'));

        return 'success';
    }

    public function tasks ($id){
        $project = Project::where('id',$id)->firstOrFail();
        
        return view('components.tasks',[
            'project'=> $project
        ])->render();
    }

    public function update (Task $task){
        $task->title = request('title');
        $task->description = request('description');
        $task->priority = request('priority');
        $task->start_date = request('start_date');
        $task->deadline = request('deadline');
        $task->members()->sync(request('members'));
        $task->save();
        return 'success';
    }

    public function destroy(Task $task){
        $task->delete();
        return 'success';
    }

    public function move(Task $task){
        $task->status = request('to');
        $task->save();
        return 'success';
    }


    public function sort(){

        foreach(request('status') as $index => $task){
            $t = Task::where('id',$task)->first();
            $t->serial = $index;
            $t->save();
        }
        
        return 'success';
    }
}
