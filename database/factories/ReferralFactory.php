<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Referral;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReferralFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $statuses = array_keys(Referral::$status);

        return [
            'email' => $this->faker->unique()->safeEmail(),
            'referred_by' => User::inRandomOrder()->first()->id,
            'status' => array_rand($statuses) + 1,
        ];
    }
}
