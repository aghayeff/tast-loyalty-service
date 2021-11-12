<?php

namespace App\Services;

use App\Models\LoyaltyPointsRule;

class LoyaltyPointsRuleService
{
    public function __construct(
        private LoyaltyPointsRule $model,
    ) {}


    public function findByRule(string $rule)
    {
        return $this->model::where('points_rule', $rule)->first();
    }


    public function matchAccrualType($model, float $paymentAmount): float|int
    {
        return match ($model->accrual_type) {
            LoyaltyPointsRule::ACCRUAL_TYPE_RELATIVE_RATE => ($paymentAmount / 100) * $model->accrual_value,
            LoyaltyPointsRule::ACCRUAL_TYPE_ABSOLUTE_POINTS_AMOUNT => $model->accrual_value
        };
    }
}
