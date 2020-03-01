<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'product_image' => 'required|image',
            'name' => 'required',
            'description' => 'required',
            'type' => 'required',
            'price' => 'required|numeric',
            'points' => 'required|numeric'
        ];
    }


    public function messages()
    {
        return [
            
        ];
    }
}