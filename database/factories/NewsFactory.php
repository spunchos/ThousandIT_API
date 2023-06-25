<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->title(),
            'announce' => $this->faker->text(15),
            'text' => $this->faker->text(50),
            'author_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
