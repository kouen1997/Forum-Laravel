<?php

namespace App\Http\Requests\Eloading;

use Illuminate\Foundation\Http\FormRequest;

class LoadTransferRequest extends FormRequest
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
            'mode' => 'required',
            'user' => 'required',
            'amount' => 'required',
            'pin' => 'required'
        ];
    }
}