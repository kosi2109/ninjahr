<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function show(Company $company){
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

        foreach($request as $key=>$value){
            $company->$key = $value;
        };

        $company->save();
        return redirect('/company/1/show')->with('success','Company Settings updated successfully.');
    }
}
