<?php

namespace App\Http\Requests\ProductInventory;

use Illuminate\Foundation\Http\FormRequest;

class OrderRemarksRequest extends FormRequest
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
            'remarks' => 'required',
            'specific_order' => 'required'
        ];
    }

    public function messages()
    {
        return [
            
        ];
    }
}