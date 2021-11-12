<?php

namespace App\Services;

use App\Models\LoyaltyPointsRule;
use App\Models\LoyaltyPointsTransaction;

class LoyaltyPointsService
{
    public function __construct(
        private LoyaltyPointsTransaction $model,
        private LoyaltyPointsRuleService $loyaltyPointsRuleService,
    ) {}


    public function findById(int $id)
    {
        return $this->model::query()
            ->where('id', $id)
            ->where('canceled', 0)
            ->first();
    }


    public function cancel($transaction, string $reason)
    {
        $transaction->canceled = time();
        $transaction->cancellation_reason = $reason;
        $transaction->save();
    }


    public function create(array $data)
    {
        return $this->model::create($data);
    }


    public function performPaymentLoyaltyPoints(int $accountId, array $params)
    {
        $pointsRule = $this->loyaltyPointsRuleService->findByRule($params['points_rule']);

        if ($pointsRule) {
            $points_amount = $this->loyaltyPointsRuleService->matchAccrualType($pointsRule, $params['payment_amount']);
        }

        $storeData = [
            'account_id' => $accountId,
            'points_rule' => $pointsRule?->id,
            'points_amount' => $points_amount ?? 0,
            'description' => $params['description'] ?? '',
            'payment_id' => $params['payment_id'],
            'payment_amount' => $params['payment_amount'] ?? null,
            'payment_time' => $params['payment_time'] ?? null,
        ];

        return $this->create($storeData);
    }
}
