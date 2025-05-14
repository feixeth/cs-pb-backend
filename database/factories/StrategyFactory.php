<?php

namespace Database\Factories;

use App\Models\Strategy;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class StrategyFactory extends Factory
{
    protected $model = Strategy::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3), // ex D2 Split B 
            'description' => $this->faker->paragraph(),
            'map' => $this->faker->randomElement(['Dust2', 'Mirage', 'Nuke', 'Overpass', 'Inferno', 'Vertigo', 'Ancient']),
            'type' => $this->faker->randomElement(['T Side', 'CT Side', 'Pistol Round', 'Eco', 'Force Buy']),
            'is_public' => $this->faker->boolean(80), // 80% pub - 20% priv
            'user_id' => User::factory(), // génère un user 
        ];
    }
}
