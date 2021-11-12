<?php

namespace Tests\Feature;

use App\Models\LoyaltyAccount;
use App\Models\LoyaltyPointsTransaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoyaltyPointsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testDeposit()
    {
        $this->authUser();

        $account = LoyaltyAccount::where('active', true)->first();

        $data = [
            'type' => 'email',
            'value' => $account->email,
            'points_rule' => 'Coffee +1%',
            'description' => 'test_deposit',
            'payment_id' => '1',
            'payment_amount' => 10,
            'payment_time' => time()
        ];

        $response = $this->post('/api/loyaltyPoints/deposit', $data);

        $response->assertSessionHasNoErrors();
    }


    public function testCancellation()
    {
        $this->authUser();

        $transaction = LoyaltyPointsTransaction::first();

        $data = [
            'transaction_id' => $transaction->id,
            'cancellation_reason' => 'test'
        ];

        $response = $this->post('/api/loyaltyPoints/cancel', $data);

        $response->assertSessionHasNoErrors();
    }


    public function testWithDraw()
    {
        $this->authUser();

        $account = LoyaltyAccount::where('active', true)->first();

        $data = [
            'type' => 'email',
            'value' => $account->email,
            'points_amount' => 0.1,
            'description' => 'test_withdraw',
        ];

        $response = $this->post('/api/loyaltyPoints/withdraw', $data);

        $response->assertSessionHasNoErrors();
    }


    private function authUser()
    {
        $user = User::where('email', 'admin@admin.com')->first();

        $this->be($user);
        $this->assertAuthenticatedAs($user);
    }
}
