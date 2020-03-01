<?php

namespace App\Http\Requests\TNT;

use Illuminate\Foundation\Http\FormRequest;

class HotelDomesticMarkupRequest extends FormRequest
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
            'hotel_domestic' => 'required|numeric'
        ];
    }


    public function messages()
    {
        return [
            
        ];
    }
}
