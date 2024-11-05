<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()
            ->count(1)
            ->create([
                'email' => 'admin@admin.com',
                'password' => \Hash::make('admin'),
            ]);

        $this->call(EntitySeeder::class);
        $this->call(ParameterSeeder::class);
        $this->call(MonitoringSeeder::class);
        $this->call(DoctorPatientSeeder::class);
        $this->call(DoctorSeeder::class);
        $this->call(PatientSeeder::class);
    }
}
