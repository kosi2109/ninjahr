<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeRequest extends FormRequest
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
        return [
            "employee_id" => ["required",Rule::unique('users','employee_id')],
            "name" => ["required"],
            "password" => ["required"],
            "phone" => ["required",Rule::unique('users','phone')],
            "email" => ["required",Rule::unique('users','email')],
            "nrc_number" => ["required",Rule::unique('users','nrc_number')],
            "gender" => ["required"],
            "pin" => ["required","min:6","max:6"],
            "birthday" => ["required"],
            "address" => ["required"],
            "department_id" => ["required",Rule::exists('departments','id')],
            "date_of_join" => ["required"],
            "is_present" => ["required"],
        ];
    }
}
