<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;


class MyProjectController extends Controller
{
    public function index()
    {
        return view("my-projects.project");
    }


    public function show($id)
    {
        $project = Project::with('leaders','members','tasks')
        ->where('id',$id)
        ->where(function($query){
            $query
            ->whereHas('leaders',function($q1){
                $q1->where('user_id',auth()->id());
            })
            ->orWhereHas('members',function($q1){
                $q1->where('user_id',auth()->id());
            });
        })
        ->firstOrFail();
        return view("project.show",[
            'project'=>$project,
        ]);
    }


    public function ssd()
    {
        $project = Project::with('leaders','members')
        ->whereHas('leaders',function($query){
            $query->where('user_id',auth()->id());
        })->orWhereHas('members',function($query){
            $query->where('user_id',auth()->id());
        }); 
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
            return Str::limit($each->description,100);
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
            $info = "<a href='/my-project/". $each->id ."' class='text-decoration-none'>
            <button class='btn btn-sm btn-outline-info' style='width:40px' ><i class='fa-solid fa-info'></i></button></a>";
            return "<div>$info</div>";
        })
        ->rawColumns(['priority','action','status','leaders','members'])
        ->make(true);
    }
}
