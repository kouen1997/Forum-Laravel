<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class UpdateProfileRequest extends FormRequest
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
            'mobile' => 'required|numeric|unique:tbl_users,mobile,'.Auth::user()->id,
            'birth_date' => 'required'
        ];
    }
}