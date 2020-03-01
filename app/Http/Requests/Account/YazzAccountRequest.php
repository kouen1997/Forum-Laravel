<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class YazzAccountRequest extends FormRequest
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
            'card_number' => 'required|numeric|digits:16'
        ];
    }

    public function messages()
    {
        return [
            'card_number.numeric'  => 'The card number must be numeric.',
            'card_number.digits'  => 'The card number must be 16 digits.',
        ];
    }
}