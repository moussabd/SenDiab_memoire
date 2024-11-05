<?php

namespace App\Filament\Resources\Panel\PatientResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\Panel\PatientResource;

class CreatePatient extends CreateRecord
{
    protected static string $resource = PatientResource::class;
}
