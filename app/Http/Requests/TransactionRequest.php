<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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
            'description' => 'required|max:30',
            'amount' => 'required|integer|max:500000000|min:10000',
            'destination_account_number'=>'required|regex:/^(?:IR)(?=.{24}$)[0-9]*$/',
        ];
    }
}
