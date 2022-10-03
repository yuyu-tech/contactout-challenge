<?php

namespace Tests\Feature\Referral;

use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShareReferralTest extends TestCase {
    use RefreshDatabase;

    /**
     * User
     *
     * @var User
     */
    protected $user;

    /**
     * Test authentication
     *
     * @return void
     */
    public function test_authentication() {
        $url = route('referrals.store');

        $response = $this->post($url);

        $response->assertRedirect('/login');
    }

    /**
     * Input data validation
     */
    public function test_input_data_validation() {
        $url = route('referrals.store');

        $response = $this->actingAs($this->getUser())->post($url)
            ->assertStatus(302);

        $this->assertDatabaseCount('referrals', 0);
    }

    /**
     * Successful request with valid data.
     */
    public function test_successful_referral_request() {
        $url = route('referrals.store');

        $faker = Factory::create();

        $input = [
            'emails' => [
                $faker->email(),
            ],
        ];

        // dd($input);
        $response = $this->actingAs($this->getUser())->postJson($url, $input)
            ->assertStatus(302);

        $this->assertDatabaseCount('referrals', count(array_unique($input['emails'])));
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
