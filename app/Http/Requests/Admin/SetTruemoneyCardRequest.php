<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SetTruemoneyCardRequest extends FormRequest
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
            'username' => 'required|alphaNum|max:255|exists:tbl_users,username',
            'card_number' => 'required',
        ];
    }


    public function messages()
    {
        return [
            'username.exists'  => 'Username doesnt exist!',
        ];
    }
}