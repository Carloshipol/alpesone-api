<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CarFactory extends Factory
{
    public function definition(): array
    {
        return [
            'external_id' => $this->faker->unique()->randomNumber(),
            'brand' => $this->faker->company,
            'model' => $this->faker->word,
            'price' => $this->faker->randomFloat(2, 50000, 200000),
            'year_model' => $this->faker->year,
            'year_build' => $this->faker->year,
            'sold' => false,
        ];
    }
}