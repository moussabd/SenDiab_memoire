<?php

namespace Database\Factories;

use App\Models\Parameter;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParameterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Parameter::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'max_value' => fake()->randomNumber(2),
            'min_value' => fake()->randomNumber(2),
            'unity' => fake()->text(255),
            'notification_min' => fake()->word(),
            'notification_max' => fake()->word(),
            'deleted_at' => fake()->dateTime(),
        ];
    }
}
