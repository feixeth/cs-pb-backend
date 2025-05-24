<?php

namespace Database\Factories;

use App\Models\Media;
use App\Models\Strategy;
use Illuminate\Database\Eloquent\Factories\Factory;

class MediaFactory extends Factory
{
    protected $model = Media::class;

    public function definition(): array
    {
        return [
            'strategy_id' => Strategy::factory(),
            'path' => fake()->imageUrl(640, 480, 'game'),
            'type' => fake()->randomElement(['lineup', 'flash', 'smoke', 'molotov']),
        ];
    }
}
