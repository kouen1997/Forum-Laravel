<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class SocialConnectRequest extends FormRequest
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
            'pin' => 'required||min:6',
            'email' => 'required|email',
            'password' => 'required|alphaNum|confirmed|min:2|max:30',
            'password_confirmation' => 'required|alphaNum|min:2|max:30'
        ];
    }
}