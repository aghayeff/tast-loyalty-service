<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoyaltyPoint\CancelLoyaltyPointRequest;
use App\Http\Requests\LoyaltyPoint\DepositLoyaltyPointRequest;
use App\Http\Requests\LoyaltyPoint\WithdrawLoyaltyPointRequest;
use App\Services\AccountService;
use App\Services\LoyaltyPointsService;
use Illuminate\Support\Facades\Log;

class LoyaltyPointsController extends Controller
{
    public function __construct(
        private LoyaltyPointsService $loyaltyPointsService,
        private AccountService $accountService,
    ) {}


    public function deposit(DepositLoyaltyPointRequest $request)
    {
        $data = $request->all();

        $account = $this->accountService->getAccountByParams($data);

        if (!$account) {
            return response()->json(['message' => 'Account is not found'], 400);
        }

        if (!$account->active) {
            return response()->json(['message' => 'Account is not active'], 403);
        }

        $transaction = $this->loyaltyPointsService->performPaymentLoyaltyPoints($account->id, $data);

        event(new \App\Events\LoyaltyPointsReceived($account, $transaction));

        return $transaction;
    }


    public function cancel(CancelLoyaltyPointRequest $request)
    {
        $data = $request->all();

        $transaction = $this->loyaltyPointsService->findById($data['transaction_id']);
        $this->loyaltyPointsService->cancel($transaction, $data['cancellation_reason']);
    }


    public function withdraw(WithdrawLoyaltyPointRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->all();

        $account = $this->accountService->getAccountByParams($data);

        if (!$account) {
            return response()->json(['message' => 'Account is not found'], 400);
        }

        if (!$account->active) {
            return response()->json(['message' => 'Account is not active'], 403);
        }

        if ($this->accountService->getBalance($account->id) < $data['points_amount']) {
            Log::info('Insufficient funds: ' . $data['points_amount']);
            return response()->json(['message' => 'Insufficient funds'], 422);
        }

        $storeData = [
            'account_id' => $account->id,
            'points_amount' => -$data['points_amount'],
            'description' => $data['description'],
        ];

        return $this->loyaltyPointsService->create($storeData);
    }
}
