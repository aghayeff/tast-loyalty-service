<?php

namespace App\Http\Requests\LoyaltyPoint;

use Illuminate\Foundation\Http\FormRequest;

class CancelLoyaltyPointRequest extends FormRequest
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
            'transaction_id' => 'required|numeric|exists:loyalty_points_transaction,id',
            'cancellation_reason' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'cancellation_reason.required' => 'Cancellation reason is not specified'
        ];
    }
}
