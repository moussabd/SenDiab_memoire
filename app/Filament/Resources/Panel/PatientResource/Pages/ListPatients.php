<?php

namespace App\Filament\Resources\Panel\PatientResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\Panel\PatientResource;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;
use App\Models\DoctorPatient;
use Illuminate\Database\Eloquent\Builder;

class ListPatients extends ListRecords
{
    protected static string $resource = PatientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableQuery(): Builder
    {
        $user = Auth::user();

        // Check if the user is a doctor
        if ($user->doctor) {
            // Get patient IDs assigned to this doctor from the doctor_patient table
            $assignedPatientIds = DoctorPatient::where('doctor_id', $user->doctor->id)
                                               ->pluck('patient_id');

            // Filter the patient list to only show patients assigned to this doctor
            return Patient::whereIn('id', $assignedPatientIds);
        }

        // Default: return all patients if the user is not a doctor
        return Patient::query();
    }
}
