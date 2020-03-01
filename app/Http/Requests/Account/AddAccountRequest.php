<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class AddAccountRequest extends FormRequest
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
            'activation_code' => 'required|max:13',
            'account_qty' => 'required|numeric',
            'placement' => 'required|max:100',
            'position' => 'required|max:20',
            'pin' => 'required|min:6|max:6'
        ];
    }
}