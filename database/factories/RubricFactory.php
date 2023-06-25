<?php

namespace Database\Factories;

use Faker\Generator;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RubricFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(10),
            'pid' => $this->faker->numberBetween(0, 15),
        ];
    }
}
