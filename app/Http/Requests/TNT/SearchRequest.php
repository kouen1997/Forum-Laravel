<?php

namespace App\Http\Requests\TNT;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'mode' => 'required',
            'air_code_from' => 'required',
            'air_code_to' => 'required',
            'departure_date' => 'required',
            'return_date' => 'required_if:mode,==,round-trip'
        ];
    }


    public function messages()
    {
        return [
            
        ];
    }
}
