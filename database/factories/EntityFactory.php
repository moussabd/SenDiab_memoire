<?php

namespace Database\Factories;

use App\Models\Entity;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class EntityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Entity::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'address' => fake()->address(),
            'type' => "Hospital",
            'phone_number' => fake()->phoneNumber(),
            'email' => fake()
                ->unique()
                ->safeEmail(),
            'deleted_at' => null,
        ];
    }
}
