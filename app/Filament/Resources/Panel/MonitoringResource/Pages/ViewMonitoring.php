<?php

namespace App\Filament\Resources\Panel\MonitoringResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\Panel\MonitoringResource;
use App\Models\Monitoring;
use Illuminate\Support\Facades\Auth;

class ViewMonitoring extends ViewRecord
{
    protected static string $resource = MonitoringResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    // Custom function to get the monitoring count for the authenticated patient
    protected function getPatientMonitoringCount(): int
    {
        $userId = Auth::id();

        return Monitoring::join('patients', 'monitoring.patient_id', '=', 'patients.id')
            ->where('patients.user_id', $userId)
            ->count();
    }
}
