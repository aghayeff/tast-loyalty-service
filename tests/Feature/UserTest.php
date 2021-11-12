<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLogin($email = 'admin@admin.com', $password = 'admin123456')
    {
        $response = $this->post('/api/user/login', ['email' => $email, 'password' => $password]);
        $response->assertSessionHasNoErrors();
//
        $user = User::where('email', $email)->first();

        $this->assertAuthenticatedAs($user);
    }

    public function testRegister()
    {
        $password = $this->faker->password();

        $user = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique->safeEmail(),
            'password' => $password,
            'password_confirmation' => $password,
        ];

        $response = $this->post('/api/user/register', $user);
        $response->assertSessionHasNoErrors();

        $this->testLogin($user['email'], $user['password']);
    }
}
