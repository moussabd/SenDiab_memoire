<?php

namespace Database\Factories;

use App\Models\Monitoring;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class MonitoringFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Monitoring::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'dateofsample' => fake()
                ->dateTime()
                ->format('Y-m-d H:i:s'),
            'comments_patients' => fake()->word(),
            'value' => fake()->randomNumber(2),
            'deleted_at' => null,
            'comments_doctor' => fake()->word(),
            'patient_id' => \App\Models\Patient::factory(),
            'parameter_id' => \App\Models\Parameter::factory(),
        ];
    }
}
