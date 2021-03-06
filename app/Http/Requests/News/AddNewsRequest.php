<?php

namespace App\Http\Requests\News;

use Illuminate\Foundation\Http\FormRequest;

class AddNewsRequest extends FormRequest
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
            'title' => 'required',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg|max:8000',
            'description' => 'required'
        ];
    }
}