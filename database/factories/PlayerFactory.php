<?php

namespace Database\Factories;

use App\Models\Player;
use App\Models\Strategy;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlayerFactory extends Factory
{
    protected $model = Player::class;

    public function definition(): array
    {
        return [
            'strategy_id' => Strategy::factory(),
            'position' => fake()->numberBetween(1, 5), // position dans l'équipe
            'role' => fake()->randomElement(['IGL', 'AWP', 'Rifle', 'Support', 'Entry']),
            'tasks' => fake()->sentence(), // "Hold banana / flash entry / smoke CT"
        ];
    }
}
