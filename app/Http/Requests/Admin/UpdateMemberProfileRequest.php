<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMemberProfileRequest extends FormRequest
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
            'email' => 'required|email|max:255|unique:tbl_users,email,'.$this->route('id'),
            'last_name' => 'required|min:1|max:50',
            'middle_name' => 'required|min:1|max:50',
            'first_name' => 'required|min:1|max:50',
            'mobile' => 'required|min:11|max:20',
            'birth_date' => 'required',
        ];
    }
}