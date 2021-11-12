<?php

namespace App\Http\Requests\LoyaltyPoint;

use App\Models\LoyaltyAccount;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DepositLoyaltyPointRequest extends FormRequest
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
            'value' => 'required|string',
            'type' => ['required', 'string', Rule::in(LoyaltyAccount::$types)],
            'points_rule' => 'nullable|string',
            'description' => 'sometimes|string',
            'payment_id' => 'required|string',
            'payment_amount' => 'nullable|numeric|gt:0',
            'payment_time' => 'nullable|integer',
        ];
    }
}
