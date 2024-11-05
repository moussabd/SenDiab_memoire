<?php

namespace App\Filament\Widgets;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use App\Models\Parameter;
use App\Models\Entity;
use App\Models\Monitoring;
use App\Models\DoctorPatient;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Illuminate\Support\Facades\Auth;

class AdminTypeOverview extends BaseWidget
{
    use HasWidgetShield;

    protected function getStats(): array
    {
        $user = Auth::user();

        // Check if the user has ID 1 (Admin)
        if ($user->id === 1) {
            // Show all stats for the admin user
            return [
                Stat::make('Nombre de médecins', Doctor::count()),
                Stat::make('Nombre de patients', Patient::count()),
                Stat::make('Nombre d\'utilisateurs', User::count()),
                Stat::make('Nombre de paramètres', Parameter::count()),
                Stat::make('Nombre d\'entités', Entity::count()),
                Stat::make('Nombre de surveillances', Monitoring::count()),
            ];
        }

        // Check if the user is a patient (assuming there's a `Patient` model and relationship)
        if ($user->patient) {
            // Show only the count of monitoring records for the logged-in patient
            $monitoringCount = Monitoring::where('patient_id', $user->patient->id)->count();

            return [
                Stat::make('Nombre de surveillances', $monitoringCount),
            ];
        }

        // Check if the user is a doctor
        if ($user->doctor) {
            // Get patient IDs assigned to this doctor from the doctor_patient table
            $assignedPatientIds = DoctorPatient::where('doctor_id', $user->doctor->id)->pluck('patient_id');

            // Count patients assigned to this doctor
            $doctorPatientCount = $assignedPatientIds->count();

            // Count monitoring records for patients assigned to this doctor
            $doctorMonitoringCount = Monitoring::whereIn('patient_id', $assignedPatientIds)->count();

            return [
                Stat::make('Nombre de patients', $doctorPatientCount),
                Stat::make('Nombre de surveillances', $doctorMonitoringCount),
            ];
        }

        // Default return (if the user is not admin ID 1, not a patient, and not a doctor)
        return [];
    }
}
