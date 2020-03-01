<?php

namespace App\Http\Requests\Payout;

use Illuminate\Foundation\Http\FormRequest;

class BdoPayoutRequest extends FormRequest
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
        //  if ($this->request->get('card_type') == "bdo") {
        //     return [
        //         'card_type' => 'required',
        //         'account_name' => 'required',
        //         'account_number' => 'required|min:9|max:13',
        //         'amount' => 'required|numeric',
        //         'pin' => 'required|min:6|max:6'
        //     ];
        // } else {
            return [
                'card_type' => 'required',
                'account_name' => 'required',
                // 'account_number' => 'required',
                'amount' => 'required|numeric',
                'pin' => 'required|min:6|max:6'
            ];
        //}
    }


    public function messages()
    {
        return [
            
        ];
    }
}
