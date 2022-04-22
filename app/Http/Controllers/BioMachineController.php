<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BiomatericAttedance;
use Yajra\DataTables\Facades\DataTables;

class BioMachineController extends Controller
{
    public function index()
    {
        return view("bio_machine.index");
    }

    public function ssd()
    {
        $bio_machine = BiomatericAttedance::all();
        return DataTables::of($bio_machine)
        ->addColumn('action',function($each){
            $eidt = "<a href='/bio-machine/". $each->id ."/edit' class='text-decoration-none'>
            <button class='btn btn-sm btn-outline-warning' style='width:40px' ><i class='fa-solid fa-pen-to-square'></i></button></a>";
            $delete = "
            <button data-id=". $each->id ." class='btn btn-sm btn-outline-danger delete' style='width:40px'><i class='fa-solid fa-trash-alt'></i></button>";
            return "<div>$eidt $delete</div>";
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function create(){

        return view('bio_machine.create');
    }

    public function store(){
        $bio_machine = new BiomatericAttedance();
        $bio_machine->machine_id = request('machine_id');
        $bio_machine->password = request('password');
        $bio_machine->location = request('location');
        $bio_machine->save();
        if(request('add_more')){
            return redirect("/bio-machine/create")->with("success","bio_machine has been successfully created .");
        }
        return redirect("/bio-machine")->with("success","bio_machine has been successfully created .");
    }

    public function edit(BiomatericAttedance $bio_machine){
        return view('bio_machine.edit',[
            "bio_machine"=>$bio_machine
        ]);
    }
    
    public function update(BiomatericAttedance $bio_machine){
        
        $bio_machine->machine_id = request('machine_id');
        $bio_machine->password = request('password');
        $bio_machine->location = request('location');
        $bio_machine->save();

        return redirect('/bio-machine')->with("success","bio_machine has been successfully updated .");
    }


    public function destroy(BiomatericAttedance $bio_machine){
        $bio_machine->delete();
        return 'success';
    }
}
