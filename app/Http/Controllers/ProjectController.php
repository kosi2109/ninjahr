<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use App\Models\ProjectLeader;
use App\Models\ProjectMember;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index()
    {
        return view("project.index");
    }


    public function show(Project $project)
    {
        $project->with('members','leaders','tasks');
        return view("project.show",[
            'project'=>$project,
        ]);
    }


    public function ssd()
    {
        $project = Project::with('leaders','members');
        return DataTables::of($project)
        ->addColumn('leaders',function($each){
            $img = "";
            foreach($each->leaders as $leader){
                $img .= "<img src='storage/$leader->profile_img' alt='img' class='rounded-circle shadow-sm me-1' width='30' height='30' />";
            }
            return $img;
        })
        ->addColumn('members',function($each){
            $img = "";
            foreach($each->members as $member){
                $img .= "<img src='storage/$member->profile_img' alt='img' class='rounded-circle shadow-sm me-1' width='30' height='30' />";
            }
            return $img;
        })
        ->editColumn('description',function($each){
            return Str::limit($each->description,150);
        })
        ->editColumn('title',function($each){
            return Str::limit($each->description,50);
        })
        ->editColumn('priority',function($each){
            if($each->priority == 'high'){
                return '<span class="badge badge-pill bg-danger">High</span>';
            }else if($each->priority == 'middle'){
                return '<span class="badge rounded-pill bg-info">Middle</span>';
            }else{
                return '<span class="badge rounded-pill bg-dark">Low</span>';
            }
        })
        ->editColumn('status',function($each){
            if($each->status == 'pending'){
                return '<span class="badge badge-pill bg-warning">Pending</span>';
            }else if($each->status == 'in_progess'){
                return '<span class="badge rounded-pill bg-primary">InProgress</span>';
            }else{
                return '<span class="badge rounded-pill bg-success">Complete</span>';
            }
        })
        ->addColumn('action',function($each){
            $info = "<a href='/project/". $each->id ."' class='text-decoration-none'>
            <button class='btn btn-sm btn-outline-info' style='width:40px' ><i class='fa-solid fa-info'></i></button></a>";
            $eidt = "<a href='/project/". $each->id ."/edit' class='text-decoration-none'>
            <button class='btn btn-sm btn-outline-warning' style='width:40px' ><i class='fa-solid fa-pen-to-square'></i></button></a>";
            $delete = "
            <button data-id=". $each->id ." class='btn btn-sm btn-outline-danger delete' style='width:40px'><i class='fa-solid fa-trash-alt'></i></button>";
            return "<div>$info $eidt $delete</div>";
        })
        ->rawColumns(['priority','action','status','leaders','members'])
        ->make(true);
    }

    public function create(){
        $users = User::all();
        return view('project.create',[
            'users'=>$users
        ]);
    }

    public function store(ProjectRequest $request){
        $images = [];
        if(request()->hasFile('images')){
            
            foreach ($request->images as $image){
                $images[] = $image->store('project/images');
            }
            
        }
        
        $files = [];
        if(request()->hasFile('files')){
            
            foreach (request()->file('files') as $file){
                $files[] = $file->store('project/files');
            }
        }
        
        $project = new Project();
        foreach ($request->all() as $key=>$value){
            if($key != "_token" && $key != "leaders" && $key != "members" && $key != "add_more" && $key != "images" && $key != "files"  ){
                $project->$key = $value;
            }
        }
        
        $project->images = $images;
        $project->files = $files;
        $project->save();

        $project->leaders()->sync($request->leaders);
        $project->members()->sync($request->members);

        if(request('add_more')){
            return redirect("/project/create")->with("success","project has been successfully created .");
        }
        return redirect("/project")->with("success","project has been successfully created .");
    }

    public function edit(Project $project){
        $users = User::all();
        return view('project.edit',[
            "project"=>$project,
            'users' => $users
        ]);
    }
    
    public function update(ProjectRequest $request,Project $project){
    
        
        if(request()->hasFile('images')){
            $images = [];
            foreach (request()->file('images') as $image){
                $images[] = $image->store('project/images');
            }
            $project->images = $images;
        }
        
        
        if(request()->hasFile('files')){
            $files = [];
            foreach (request()->file('files') as $file){
                $files[] = $file->store('project/files');
            }
            $project->files = $files;
        }


        foreach ($request->all() as $key=>$value){
            if($key != "_token" && $key != "leaders" && $key != "members" && $key != "add_more" && $key != "images" && $key != "files"  ){
                $project->$key = $value;
            }
        }

        $project->save();

        $project->leaders()->sync(request('leaders'));
        $project->members()->sync(request('members'));

        return redirect('/project')->with("success","project has been successfully updated .");
    }


    public function destroy(Project $project){

        $leaders = ProjectLeader::where('project_id',$project->id)->get();
        foreach ($leaders as $leader){
            $leader->delete();
        }

        $members = ProjectMember::where('project_id',$project->id)->get();
        foreach ($members as $member){
            $member->delete();
        }

        $project->delete();
        return 'success';
    }
}
