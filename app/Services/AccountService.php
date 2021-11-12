<?php

namespace App\Services;

use App\Events\AccountActivated;
use App\Events\AccountDeactivated;
use App\Models\LoyaltyAccount;
use App\Models\LoyaltyPointsTransaction;

class AccountService
{
    public function __construct(
        private LoyaltyAccount $model,
    ) {}


    public function create(array $data)
    {
        return $this->model::create($data);
    }


    public function activate(LoyaltyAccount $account)
    {
        if (!$account->active) {
            $account->active = true;
            $account->save();

            event(new AccountActivated($account));
        }
    }


    public function deactivate(LoyaltyAccount $account)
    {
        if ($account->active) {
            $account->active = false;
            $account->save();

            event(new AccountDeactivated($account));
        }
    }


    public function getAccountByParams(array $params)
    {
        return $this->model::where($params['type'], $params['value'])->first();
    }


    public function getBalance($accountId): float
    {
        return LoyaltyPointsTransaction::where('canceled', 0)
            ->where('account_id', $accountId)
            ->sum('points_amount');
    }
}
