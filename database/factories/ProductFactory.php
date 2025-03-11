<?php

namespace Database\Factories;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->sentence(3),
            "status" => $this->faker->randomElement([StatusEnum::Allowed->value, StatusEnum::Prohibited->value])
        ];
    }
}