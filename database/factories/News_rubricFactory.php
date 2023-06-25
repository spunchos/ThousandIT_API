<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class News_rubricFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'rubric_id' => $this->faker->numberBetween(1, 15),
            'news_id'   => $this->faker->numberBetween(1, 20),
        ];
    }
}
