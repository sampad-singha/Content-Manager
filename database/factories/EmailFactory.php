<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EmailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'subject' => $this->faker->sentence(),
            'body' => $this->faker->paragraph(),
            'receiver' => $this->faker->email(),
        ];
    }
}
