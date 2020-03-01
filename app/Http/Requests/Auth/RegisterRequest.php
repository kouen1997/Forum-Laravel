<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'username' => 'required|alphaNum|max:255|unique:tbl_users,username',
            'email' => 'required|email|max:255|unique:tbl_users,email',
            'password' => 'required|alphaNum|confirmed|min:6|max:20',
            'last_name' => 'required|min:1|max:50',
            'middle_name' => 'min:1|max:50',
            'first_name' => 'required|min:1|max:50',
            'mobile' => 'required|min:11|max:20',
            'sponsor' => 'required|max:100|exists:tbl_users,username',
            'pin' => 'required|alphaNum|confirmed|min:6|max:6',
            //'g-recaptcha-response' => 'required|captcha',
        ];
    }


    public function messages()
    {
        return [
            'sponsor.exists'  => 'We couldn\'t find your sponsor. Please double-check and try again.',
            'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
            'g-recaptcha-response.captcha'  => 'Captcha error! try again later or contact site admin.',
        ];
    }
}
