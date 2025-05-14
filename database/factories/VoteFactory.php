<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Strategy;
use App\Models\Vote;
use Illuminate\Database\Eloquent\Factories\Factory;

class VoteFactory extends Factory
{
    protected $model = Vote::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'strategy_id' => Strategy::factory(),
            'value' => $this->faker->randomElement([1, -1]),
        ];
    }
}
