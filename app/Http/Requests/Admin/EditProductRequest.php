<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EditProductRequest extends FormRequest
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

        if($this->has('product_image') && $this->has('product_image') != 'undefined'){
            $rules['product_image'] = 'image';
        }
        $rules['name'] = 'required';
        $rules['description'] = 'required';
        $rules['type'] = 'required';
        $rules['price'] = 'required|numeric';
        $rules['points'] = 'required|numeric';
        

        return $rules;
    }


    public function messages()
    {
        return [
            
        ];
    }
}