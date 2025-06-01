<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'content' => $this->faker->paragraph(),
            'note' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'university' => $this->faker->company(),
        ];
    }
}
