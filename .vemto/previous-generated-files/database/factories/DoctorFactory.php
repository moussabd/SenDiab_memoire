<?php

namespace Database\Factories;

use App\Models\Doctor;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class DoctorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Doctor::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'matricule' => fake()->text(255),
            'speciality' => fake()->text(255),
            'num_ordre' => fake()->text(255),
            'deleted_at' => fake()->dateTime(),
            'user_id' => \App\Models\User::factory(),
            'entity_id' => \App\Models\Entity::factory(),
        ];
    }
}
