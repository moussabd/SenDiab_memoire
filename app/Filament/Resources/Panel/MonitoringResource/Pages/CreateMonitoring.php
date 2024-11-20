<?php

namespace App\Filament\Resources\Panel\MonitoringResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\Panel\MonitoringResource;
use App\Models\Parameter;
use App\Models\DoctorPatient;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class CreateMonitoring extends CreateRecord
{
    protected static string $resource = MonitoringResource::class;

    public function create(bool $another = false): void
    {
        parent::create($another);
        try {
            // Récupération des données du formulaire
            $data = $this->form->getState();
            $parameter = Parameter::find($data['parameter_id']);
            $value = $data['value'];
            $message = null;

            // Vérification des seuils
            if ($value > $parameter->max_value) {
                $message = $parameter->notification_max;
            } elseif ($value < $parameter->min_value) {
                $message = $parameter->notification_min;
            }

            // Si une notification est nécessaire
            if (!empty($message)) {
                // Récupérer le patient et le médecin associés
                $patient = auth()->user();
                $patientName = "{$patient->firstname} {$patient->lastname}";
                $admin = \App\Models\User::find(1); // Utilisateur ayant l'ID 1
                $doctor = DoctorPatient::where('patient_id', $patient->patient->id)
                    ->first()?->doctor->user;

                // Titre de notification avec le nom du patient
                $title = "Notification concernant le patient : $patientName";

                // Envoyer la notification à l'admin
                if ($admin) {
                    Notification::make()
                        ->title($title)
                        ->body($message)
                        ->warning()
                        ->sendToDatabase($admin);
                }

                // Envoyer la notification au patient
                Notification::make()
                    ->title($title)
                    ->body($message)
                    ->info()
                    ->sendToDatabase($patient);

                // Envoyer la notification au médecin
                if ($doctor) {
                    Notification::make()
                        ->title($title)
                        ->body($message)
                        ->success()
                        ->sendToDatabase($doctor);
                }
            }
        } catch (\Exception $e) {
            // En cas d'erreur, loguer l'erreur pour debug
            Log::error($e->getMessage());
        }
    }
}
