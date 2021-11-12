<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class StoreAccountRequest extends FormRequest
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
            'phone' => 'required|string|unique:loyalty_account,phone',
            'card' => 'required|string|unique:loyalty_account,card',
            'email' => 'required|string|unique:loyalty_account,email',
            'email_notification' => 'boolean',
            'phone_notification' => 'boolean',
            'active' => 'boolean',
        ];
    }
}
