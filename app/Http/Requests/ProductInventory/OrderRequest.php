<?php

namespace App\Http\Requests\ProductInventory;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'products' => 'required|array',
            'quantity' => 'required|array',
            'name' => 'required',
            'contact_number' => 'required',
            'delivery_address' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'product.exists'  => 'Product doesnt exist!',
        ];
    }
}