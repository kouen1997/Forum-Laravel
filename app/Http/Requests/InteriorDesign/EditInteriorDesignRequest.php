<?php

namespace App\Http\Requests\InteriorDesign;

use Illuminate\Foundation\Http\FormRequest;

class EditInteriorDesignRequest extends FormRequest
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
            'mobile' => 'required|numeric',
            'property_type' => 'required'
        ];
    }
}