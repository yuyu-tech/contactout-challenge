<?php

namespace Tests\Feature\Referral;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListingReferralTest extends TestCase {
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
        $url = route('referrals');

        $response = $this->get($url);

        $response->assertRedirect('/login');
    }

    /**
     * Authenticated user can view this page
     */
    public function test_authenticated_user_can_view_listing_page() {
        $url = route('referrals');

        $response = $this->actingAs($this->getUser())->get($url);

        $response->assertStatus(200);
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
