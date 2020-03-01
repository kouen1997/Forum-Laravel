<?php

namespace App\Http\Requests\Support;

use Illuminate\Foundation\Http\FormRequest;

class NewTicketRequest extends FormRequest
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
            'subject' => 'required',
            'details' => 'required|min:10',
            'category' => 'required'
        ];
    }


    public function messages()
    {
        return [
            
        ];
    }
}
