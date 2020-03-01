<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateMemberRequest extends FormRequest
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

    public function rules()
    {
        return [
            'username' => 'required|alphaNum|max:255|unique:tbl_users,username',
            'email' => 'required|email|max:255|unique:tbl_users,email',
            'password' => 'required|alphaNum|min:6|max:30',
            'last_name' => 'required|min:3|max:50',
            'first_name' => 'required|min:2|max:50',
            'mobile' => 'required|min:11|max:20',
            'sponsor' => 'required|max:100|exists:tbl_users,username',
            'role' => 'required|digits_between:1,3',
            'pin' => 'required|alphaNum|min:6|max:6',
        ];
    }


    public function messages()
    {
        return [
            'sponsor.exists'  => 'Sponsor doesnt exist!',
        ];
    }
}