<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfilePinRequest extends FormRequest
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
            'current_password' => 'required|alphaNum|min:6|max:50',
            'pin' => 'required|alphaNum|confirmed|min:6|max:6',
            'pin_confirmation' => 'required|alphaNum|min:6|max:6'
        ];
    }
}