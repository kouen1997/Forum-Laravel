<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MasterFundRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'amount' => 'required|numeric',
            'username' => 'required|exists:tbl_users,username',
            'pin' => 'required|min:6|max:6'
        ];
    }

    public function messages()
    {
        return [
            'username.exists'  => 'Username doesnt exist!',
        ];
    }
}