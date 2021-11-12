<?php

namespace App\Http\Controllers;

use App\Http\Requests\Account\ActivateAccountRequest;
use App\Http\Requests\Account\StoreAccountRequest;
use App\Models\LoyaltyAccount;
use App\Services\AccountService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class AccountController extends Controller
{
    public function __construct(private AccountService $accountService)
    {

    }


    public function create(StoreAccountRequest $request)
    {
        return $this->accountService->create($request->all());
    }


    public function activate(ActivateAccountRequest $request): \Illuminate\Http\JsonResponse
    {
        $account = $this->accountService->getAccountByParams($request->all());

        if (!$account) {
            return response()->json(['message' => 'Account is not found'], 400);
        }

        $this->accountService->activate($account);

        return response()->json(['message' => 'Account is activated']);
    }


    public function deactivate(ActivateAccountRequest $request): \Illuminate\Http\JsonResponse
    {
        $account = $this->accountService->getAccountByParams($request->all());

        if (!$account) {
            return response()->json(['message' => 'Account is not found'], 400);
        }

        $this->accountService->deactivate($account);

        return response()->json(['message' => 'Account is deactivated']);
    }


    public function balance($type, $value): \Illuminate\Http\JsonResponse
    {
        $params = [
            'type' => $type,
            'value' => $value
        ];

        $validated = Validator::make($params, [
            'type' => ['required', 'string', Rule::in(LoyaltyAccount::$types)],
            'value' => ['required', 'string']
        ]);

        if ($validated->fails()) {
            return response()->json(['message' => 'Wrong parameters'], 422);
        }

        $account = $this->accountService->getAccountByParams($params);

        if (!$account) {
            return response()->json(['message' => 'Account is not found'], 400);
        }

        $balance = $this->accountService->getBalance($account->id);

        return response()->json(['balance' => $balance]);
    }
}
