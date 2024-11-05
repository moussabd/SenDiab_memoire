<?php

namespace App\Filament\Resources\Panel\MonitoringResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\Panel\MonitoringResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Monitoring;
use App\Models\DoctorPatient;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\CheckboxList;

class ListMonitorings extends ListRecords
{
    protected static string $resource = MonitoringResource::class;

    

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableQuery(): Builder
    {
        $user = Auth::user();

        // Check if the user is the admin with ID 1
        if ($user->id === 1) {
            // Admin view: return all monitoring records
            return Monitoring::query();
        }

        // Check if the user is a patient
        if ($user->patient) {
            // Patient view: return only monitoring records for the authenticated patient's ID
            return Monitoring::query()
                ->where('patient_id', $user->patient->id);
        }

        // Check if the user is a doctor
        if ($user->doctor) {
            // Get the list of patient IDs assigned to this doctor
            $assignedPatientIds = DoctorPatient::where('doctor_id', $user->doctor->id)
                                               ->pluck('patient_id');

            // Doctor view: return monitoring records only for assigned patients
            return Monitoring::query()
                ->whereIn('patient_id', $assignedPatientIds);
        }

        // Default: return an empty query if the user has no specific role
        return Monitoring::query()->whereRaw('0 = 1');
    }


    
}
