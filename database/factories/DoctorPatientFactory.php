<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\DoctorPatient;
use Illuminate\Database\Eloquent\Factories\Factory;

class DoctorPatientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DoctorPatient::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'deleted_at' => null,
            'patient_id' => \App\Models\Patient::factory(),
            'doctor_id' => \App\Models\Doctor::factory(),
        ];
    }
}
