<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

class RegistrationTest extends TestCase {
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered() {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register() {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    /**
     * Register a using referral code
     */
    public function test_registration_using_referral_code() {
        $user = $this->getUser();
        $data = $this->testData(true);

        $response = $this->post('/register', $data);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);

        $this->assertTrue($user->referrals()->where('email', $data['email'])->count() === 1);
    }

    /**
     * Get test data
     */
    protected function testData($hasCode = false): array{
        $faker = Factory::create();

        $data = [
            'name' => $faker->name(),
            'email' => $faker->unique()->safeEmail(),
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        if ($hasCode) {
            $user = $this->getUser();
            $data['code'] = Crypt::encryptString($user->email);
        }

        return $data;
    }

    /**
     * Get User
     */
    protected function getUser(): User {
        if (empty($this->user)) {
            $this->user = User::factory()->create();
        }

        return $this->user;
    }
}
