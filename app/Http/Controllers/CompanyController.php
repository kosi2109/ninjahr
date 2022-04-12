<?php

namespace App\Http\Controllers;

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

    public function update(Company $company){
        $formData = request()->validate([
            "company_name" => "required",
            "company_phone" => "required",
            "company_email" => "required",
            "office_start_time" => "required",
            "office_end_time" => "required",
            "break_start_time" => "required",
            "break_end_time" => "required"
        ]);

        foreach($formData as $key=>$value){
            $company->$key = $value;
        };

        $company->save();
        return redirect('/company/1/show')->with('success','Company Settings updated successfully.');
    }
}
