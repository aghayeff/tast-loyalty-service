<?php

namespace App\Http\Requests\LoyaltyPoint;

use App\Models\LoyaltyAccount;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WithdrawLoyaltyPointRequest extends FormRequest
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
            'points_amount' => 'required|numeric|gt:0',
            'description' => 'sometimes|string',
        ];
    }
}
