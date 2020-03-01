<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
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
            'buy_code' => 'required',
            'activation' => 'required',
            'eloading' => 'required',
            'bdo_payout' => 'required',
            'truemoney_payout' => 'required',
            'paypal_payout' => 'required',
            'dealer_payout' => 'required',
            'ofw_dealer_payout' => 'required',
            'minimum_encashment' => 'required',
            'move_to_wallet' => 'required'
        ];
    }
}