<?php

namespace Database\Factories;

use App\Models\Lineup;
use App\Models\Strategy;
use Illuminate\Database\Eloquent\Factories\Factory;

class LineupFactory extends Factory
{
    protected $model = Lineup::class;

    public function definition(): array
    {
        return [
            'strategy_id' => Strategy::factory(),
            'title' => fake()->words(3, true), // ex: "CT spawn smoke"
            'image' => fake()->imageUrl(640, 480, 'game'), // URL factice pour l’image
        ];
    }
}
