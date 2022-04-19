<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\BiomatericAttedance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class BiomatericAttedanceController extends Controller
{
    public function login (){
        return view('bioattendance.login');
    }
    
    public function store (){
        $formData = request()->validate([
            "machine_id" => "required",
            "password" => "required"
        ]);
      
        if(Auth::guard('biomateric_attedance')->attempt(['machine_id'=>$formData['machine_id'],'password'=>$formData['password']])){
            return redirect('/check-users');
        }else{
            return back()->with('error','Someting Went Wrong');
        }
    }

    public function checkUsers (){
        
        $machine = auth('biomateric_attedance')->user()->machine_id;
        $date = Carbon::now()->format('Y-m-d');
        $qr = Crypt::encryptString($machine.'#'.$date);
        return view('bioattendance.check',[
            'qr'=>$qr
        ]);
    }

    public function check_in_out(){
        if(Carbon::now()->format('D') == "Sun" || Carbon::now()->format('D') == "Sat"){
            return ['error'=> 'Today is offday'];
        } 

        if(request('data') === "" || request('data') === null){
            return ['error'=> 'Data Not Found'];
        }

        $qr_data = explode('#',Crypt::decryptString(request('data'))) ;
        $machine_id = $qr_data[0];
        $qr_date = $qr_data[1];
        $today = Carbon::now()->format('Y-m-d');

        if($machine_id === "" || $machine_id === null){
            return ['error'=> 'Incorrect Machine'];
        }
        
        if($today !== $qr_date){
            return ['error'=> 'Something Wrong'];
        }

        if (request('pin') !== auth()->user()->pin){
            return ['error'=> 'Incorrect Pin'];
        }

        $message = '';

        $machine = BiomatericAttedance::where('machine_id',$machine_id)->first();

        if(!$machine){
            return ['error'=> 'Incorrect Machine'];
        }

        
        $exist = Attendance::where(function($query) use($today) {
                            $query->where('user_id',auth()->id())
                            ->where('date',(string) $today);
                            })->first();

                            
        if($exist){
            $attendance = $exist;
            if ($attendance->check_in && $attendance->check_out){
                return ['error'=> 'You have done your attedance for today .'];
            }elseif ($attendance->check_in){
                $attendance->check_out = Carbon::now()->format('H:i');
                $attendance->save();
                $message = 'Check Out Complete .';
            }else{
                $attendance->check_in = Carbon::now()->format('H:i');
                $attendance->save();
                $message = 'Check In Complete .';
            }
        }else{
            $attendance = new Attendance();
            $attendance->biomateric_attedance_id = $machine->id;
            $attendance->user_id = auth()->id();
            $attendance->check_in = Carbon::now()->format('H:i');
            $attendance->date = Carbon::now()->format('Y-m-d');
            $message = 'Check In Complete .';
        }
        
        
        
        $attendance->save();
        return ['message'=> $message];
        
        
    }

    public function attendance(){
        return view('bioattendance.attedance');
    }

    public function username()
    {
        return 'machine_id';
    }
}
