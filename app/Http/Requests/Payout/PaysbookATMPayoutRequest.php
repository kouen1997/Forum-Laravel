<?php

namespace App\Http\Requests\Payout;

use Illuminate\Foundation\Http\FormRequest;

class PaysbookATMPayoutRequest extends FormRequest
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
                'account_number' => 'required',
                'amount' => 'required|numeric',
                'pin' => 'required|min:6|max:6'
            ];
    }


    public function messages()
    {
        return [
            
        ];
    }
}
