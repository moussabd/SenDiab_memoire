<?php

namespace Database\Seeders;

use App\Models\DoctorPatient;
use Illuminate\Database\Seeder;

class DoctorPatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DoctorPatient::factory()
            ->count(5)
            ->create();
    }
}
