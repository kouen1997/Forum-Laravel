<?php

namespace App\Http\Requests\ProductInventory;

use Illuminate\Foundation\Http\FormRequest;

class OrderReceiptRequest extends FormRequest
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
            'receipt' => 'required|image',
            'date_time' => 'required',
            'branch' => 'required',
            'reference_no' => 'required|unique:tbl_orders'
        ];
    }

    public function messages()
    {
        return [
            
        ];
    }
}