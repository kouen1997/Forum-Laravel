<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class AtmAccountRequest extends FormRequest
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
        if(Auth::user()->atm_kyc == null){
            return [
                'first_name' => 'required|min:2|max:50',
                'last_name' => 'required|min:2|max:50',
                'mother_maiden_name' => 'required|min:5|max:100',
                'card_name' => 'required|min:3|max:26',
                'home_address' => 'required|min:10',
                'email' => 'required|email',
                'birth_date' => 'required',
                'gender' => 'required',
                'civil_status' => 'required',
                'dependents' => 'required|numeric',
                'citizenship' => 'required',
                'mobile_number' => 'required|numeric',
                'employed' => 'required',
                'source_of_fund' => 'required',
                'position' => 'required',
                'annual_income' => 'required|numeric',
                'employer_name' => 'required|min:10',
                'employer_address' => 'required|min:10',
                'submitted_id' => 'required|image|mimes:jpeg,png,jpg,gif|max:300',
                'submitted_id_no' => 'required|unique:tbl_atm_kyc,submitted_id_no',
                'shipping_address' => 'required|min:10',
                'pin' => 'required'
            ];
        } else {
            return [
                'first_name' => 'required|min:2|max:50',
                'last_name' => 'required|min:2|max:50',
                'mother_maiden_name' => 'required|min:5|max:100',
                'card_name' => 'required|min:3|max:26',
                'home_address' => 'required|min:10',
                'email' => 'required|email',
                'birth_date' => 'required',
                'gender' => 'required',
                'civil_status' => 'required',
                'dependents' => 'required|numeric',
                'citizenship' => 'required',
                'mobile_number' => 'required|numeric',
                'employed' => 'required',
                'source_of_fund' => 'required',
                'position' => 'required',
                'annual_income' => 'required|numeric',
                'employer_name' => 'required|min:10',
                'employer_address' => 'required|min:10',
                'submitted_id' => 'image|mimes:jpeg,png,jpg,gif|max:300',
                'submitted_id_no' => 'required|unique:tbl_atm_kyc,submitted_id_no,'.Auth::user()->atm_kyc->id,
                'shipping_address' => 'required|min:10',
                'pin' => 'required'
            ];
        }
    }

    public function messages()
    {
        return [
            'submitted_id.max'  => 'The valid id may not be greater than 300 kilobytes.',
            'submitted_id_no.required'  => 'The valid id no is required.',
        ];
    }
}