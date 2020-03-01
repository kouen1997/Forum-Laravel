<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class TruemoneyAccountRequest extends FormRequest
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
            'last_name' => 'required',
            'first_name' => 'required',
            'middle_name' => 'required',
            'street' => 'required',
            'card_number' => 'required',
            'barangay' => 'required',
            'city' => 'required',
            'province' => 'required',
            'birth_date' => 'required',
            'birth_place' => 'required',
            'nationality' => 'required',
            'gender' => 'required',
            'emloyer_username' => 'required',
            'source_of_fund' => 'required',
            'gov_id' => 'required',
            'gov_id_number' => 'required',
            'mobile_number' => 'required',
            'order_address' => 'required',
            'pin' => 'required'
        ];
    }
}