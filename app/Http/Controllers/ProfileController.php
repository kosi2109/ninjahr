<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function loginOption(){
        
        if(request('phone') === "" || request('phone') == null ){
            return redirect('/');
        };
        return view('auth.option');
    }
    public function show(){
        $user = auth()->user();
        $biomateric = DB::table('web_authn_credentials')->where('user_id',$user->id)->get();

        
        return view('employee.show',[   
            'user'=> $user,
            'biomateric' => $biomateric
        ]);
    }

    public function bioData(){
        $user = auth()->user();
        $biomateric = DB::table('web_authn_credentials')->where('user_id',$user->id)->get();
        return view('components.bio-datas',[   
            'biomateric' => $biomateric
        ])->render();
    }

    public function bioDestroy ($id){
        $user = auth()->user();
        $biomateric = DB::table('web_authn_credentials')->where('id',$id)->get()->first();
        if($biomateric->user_id !== $user->id ){
            return 'fail' ;
        };

        DB::table('web_authn_credentials')->where('id',$id)->delete();
        return 'success' ;
    }
}
