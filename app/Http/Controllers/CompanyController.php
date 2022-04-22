<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function show(){
        $company = Company::first();
        return view('company.show',[
            'company'=>$company
        ]);
    }

    public function edit(Company $company){
        return view('company.edit',[
            'company'=>$company
        ]);
    }

    public function update(CompanyRequest $request,Company $company){

        foreach($request->all() as $key=>$value){
            if($key != "_token"){
                $company->$key = $value;
            }
        };

        $company->save();
        return redirect('/company')->with('success','Company Settings updated successfully.');
    }
}
