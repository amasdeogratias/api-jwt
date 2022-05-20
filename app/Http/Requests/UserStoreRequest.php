<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'COMPANYWISEUSERSLIST.*.USERDETAILS.*.USERNAME' => 'required|USERNAME|unique:users',
            'COMPANYWISEUSERSLIST.*.COMPANYNAME' => 'required',
            'COMPANYWISEUSERSLIST.*.USERDETAILS.*.MOBILELOGINSTATUS' => 'required',
            
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'USERNAME.required' => 'username field is required!',
            'COMPANYNAME.required' => 'company name is required!',
            'MOBILELOGINSTATUS.required' => 'mobileloginstatus is required!',
            'password.required' => 'Password is required!'
        ];
    }
}
