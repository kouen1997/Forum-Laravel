<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMemberYazzAccountRequest extends FormRequest
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

    public function rules()
    {
        return [
            'card_number' => 'required|numeric|unique:tbl_yazz_account,card_number,'.$this->route('id').',user_id',
            'card_payment' => 'numeric',
            'shipping_cost' => 'numeric'
        ];
    }
}