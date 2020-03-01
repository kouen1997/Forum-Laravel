<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class CTBCAccountRequest extends FormRequest
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
            'bank_account_number' => 'nullable|numeric|digits:12',
            'cash_account_number' => 'nullable|numeric|digits:16'
        ];
    }

    public function messages()
    {
        return [
            'bank_account_number.numeric'  => 'The savings account number must be numeric.',
            'bank_account_number.digits'  => 'The savings account number must be 12 digits.',
        ];
    }
}