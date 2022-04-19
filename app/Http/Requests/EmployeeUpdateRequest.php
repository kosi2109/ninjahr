<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
       
    {
        $user = User::where('employee_id',request('employee_id'))->first();
        return [
            "employee_id" => ["required",Rule::unique('users','employee_id')->ignore($user->id)],
            "name" => ["required"],
            "phone" => ["required",Rule::unique('users','phone')->ignore($user->id)],
            "email" => ["required",Rule::unique('users','email')->ignore($user->id)],
            "nrc_number" => ["required",Rule::unique('users','nrc_number')->ignore($user->id)],
            "gender" => ["required"],
            "birthday" => ["required"],
            "address" => ["required"],
            "department_id" => ["required",Rule::exists('departments','id')],
            "date_of_join" => ["required"],
            "is_present" => ["required"]
        ];
    }
}
