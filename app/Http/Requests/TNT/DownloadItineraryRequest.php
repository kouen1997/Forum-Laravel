<?php

namespace App\Http\Requests\TNT;

use Illuminate\Foundation\Http\FormRequest;

class DownloadItineraryRequest extends FormRequest
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
            'flight' => 'required',
            'itinerary_key' => 'required'
        ];
    }


    public function messages()
    {
        return [
            
        ];
    }
}
