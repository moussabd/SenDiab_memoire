<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Patient;
use App\Models\Monitoring;
use App\Models\DoctorPatient;
use Illuminate\Support\Facades\Auth;

class UsersChart extends ChartWidget
{
    protected static ?string $heading = 'Diabetes Evolution Curve';

    // Properties to store the selected patient's matricule and ID
    public ?string $selectedPatientMatricule = null;
    public ?int $selectedPatientId = null;

    protected function getFilters(): ?array
    {
        $user = Auth::user();
        
        // If the user is an admin
        if ($user->id === 1) { 
            return Patient::join('users', 'patient.user_id', '=', 'users.id')
                ->select('patient.id', 'patient.matricule', 'users.firstname', 'users.lastname')
                ->get()
                ->mapWithKeys(function ($patient) {
                    return [
                        $patient->id => "{$patient->firstname} {$patient->lastname} - {$patient->matricule}"
                    ];
                })
                ->toArray();
        } elseif ($user->doctor) { 
            // If the user is a doctor, retrieve assigned patients
            return DoctorPatient::where('doctor_id', $user->doctor->id)
                ->join('patient', 'doctor_patient.patient_id', '=', 'patient.id')
                ->join('users', 'patient.user_id', '=', 'users.id')
                ->select('patient.id', 'patient.matricule', 'users.firstname', 'users.lastname')
                ->get()
                ->mapWithKeys(function ($patient) {
                    return [
                        $patient->id => "{$patient->firstname} {$patient->lastname} - {$patient->matricule}"
                    ];
                })
                ->toArray();
        } 

        // If the user is a patient, return only their own matricule
        $patient = $user->patient;
        return $patient ? [
            $patient->id => "{$user->firstname} {$user->lastname} - {$patient->matricule}"
        ] : [];
    }

    protected function getData(): array
    {
        $query = Monitoring::query();
        $selectedPatientId = $this->filter;
        $user = Auth::user();

        if ($user->id === 1) {
            if ($selectedPatientId) {
                $query->where('patient_id', $selectedPatientId);
            }
        } elseif ($user->doctor) {
            $assignedPatientIds = DoctorPatient::where('doctor_id', $user->doctor->id)->pluck('patient_id');
            if ($selectedPatientId && $assignedPatientIds->contains($selectedPatientId)) {
                $query->where('patient_id', $selectedPatientId);
            } else {
                $query->whereIn('patient_id', $assignedPatientIds);
            }
        } else {
            $patient = $user->patient;
            if ($patient) {
                $query->where('patient_id', $patient->id);
            }
        }

        $dates = $query->orderBy('dateofsample')->pluck('dateofsample')->toArray();
        $dataValues = $query->orderBy('dateofsample')->pluck('value')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Diabetes Levels',
                    'data' => $dataValues,
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                ],
            ],
            'labels' => $dates,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    public function applyFilter(string $filter): void
    {
        $this->selectedPatientId = $filter ? (int)$filter : null;
        $this->selectedPatientMatricule = null;
    }
}
