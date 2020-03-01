<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EditPropertyRequest extends FormRequest
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
            'offer_type' => 'required',
            'property_type' => 'required',
            'sub_type' => 'required',
            'title' => 'required',
            'description' => 'required',
            'bedrooms' => 'required',
            'baths' => 'required',
            'floor_area' => 'required',
            'floor_number' => 'required',
            'condominium_name' => 'required',
            'price' => 'required',
            'available_from' => 'required',
            'province' => 'required',
            'city' => 'required',
            'barangay' => 'required',
            'address' => 'required',
            'name' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:8000'
        ];
    }

}