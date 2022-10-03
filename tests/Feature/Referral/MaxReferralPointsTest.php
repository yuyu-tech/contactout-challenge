<?php

namespace Tests\Feature\Referral;

use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

class MaxReferralPointsTest extends TestCase {
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_max_points_limit() {
        $user = $this->getUser();

        for ($count = 0; $count < 20; $count++) {
            $data = $this->testData(true);
            $this->post('/register', $data);
            Auth::logout();

            $registeredReferralCount = $user->referrals()->where('status', 3)->count();
            $this->assertTrue(($registeredReferralCount < 10 && $user->referral_points == $registeredReferralCount) || $user->referral_points == 10);
        }

        $this->assertTrue($registeredReferralCount === 20);

    }

    protected function registerReferralUser() {

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
