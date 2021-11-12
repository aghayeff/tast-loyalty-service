<?php

namespace Tests\Feature;

use App\Models\LoyaltyAccount;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testCreate()
    {
        $this->authUser();

        $account = [
            'phone' => $this->faker->unique->phoneNumber,
            'card' => $this->faker->unique->creditCardNumber,
            'email' => $this->faker->unique->safeEmail(),
            'active' => false,
        ];

        $response = $this->post('/api/account/create', $account);

        $response->assertSessionHasNoErrors();
    }

    public function testActivate()
    {
        $this->authUser();

        $account = LoyaltyAccount::where('active', false)->first();

        $data = [
            'type' => 'email',
            'value' => $account->email
        ];

        $response = $this->post('/api/account/activate', $data);

        $response->assertSessionHasNoErrors();
    }

    public function testDeActivate()
    {
        $this->authUser();

        $account = LoyaltyAccount::where('active', true)->first();

        $data = [
            'type' => 'email',
            'value' => $account->email
        ];

        $response = $this->post('/api/account/deactivate', $data);

        $response->assertSessionHasNoErrors();
    }

    public function testGetBalance()
    {
        $this->authUser();

        $account = LoyaltyAccount::where('active', true)->first();

        $response = $this->get('/api/account/balance/email/' . $account->email);
        $response->assertSessionHasNoErrors();

        return $response->dump();
    }

    private function authUser()
    {
        $user = User::where('email', 'admin@admin.com')->first();

        $this->be($user);
        $this->assertAuthenticatedAs($user);
    }
}
