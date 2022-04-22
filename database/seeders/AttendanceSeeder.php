<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Attendance::truncate();
        $users = User::all();
        foreach($users as $user){
            $period = new CarbonPeriod('2021-04-01','2021-04-21');
            foreach($period as $p){
                if ($p->format('D') != 'Sun' && $p->format('D') != 'Sat'){
                    $check_in = rand(8,10);
                    $check_out = rand(10,16);
                    $attendance = new Attendance();
                    $attendance->user_id = $user->id;
                    $attendance->biomateric_attedance_id = 1;
                    $attendance->check_in = $check_in < 10 ? '0' .$check_in. ':00' : $check_in. ':00';
                    $attendance->check_out = $check_out .':15';;
                    $attendance->date = $p->format('Y-m-d');
                    $attendance->save();
                }
            }
        }
    }
}
