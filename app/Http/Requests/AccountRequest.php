<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
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
            'second_password' => 'required|regex:/^([0-9]{4}|[0-9]{6})$/',
            'firstname' => 'required|max:50|string',
            'lastname' => 'required|max:50|string',
            'deposit' => 'required|regex:/^(?:IR)(?=.{24}$)[0-9]*$/',
            'phone' => 'required|regex:09(1[0-9]|3[1-9]|2[1-9])-?[0-9]{3}-?[0-9]{4}',
            'bankName' => 'required',

        ];
    }
}
