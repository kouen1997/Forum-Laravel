<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TransferCodesRequest extends FormRequest
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
            'username' => 'required|exists:tbl_users,username',
            'quantity' => 'required|numeric',
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