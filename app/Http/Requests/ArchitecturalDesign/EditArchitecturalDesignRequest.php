<?php

namespace App\Http\Requests\ArchitecturalDesign;

use Illuminate\Foundation\Http\FormRequest;

class EditArchitecturalDesignRequest extends FormRequest
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