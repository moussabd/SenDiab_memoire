<?php

namespace App\Filament\Resources\Panel\EntityResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\Panel\EntityResource;

class CreateEntity extends CreateRecord
{
    protected static string $resource = EntityResource::class;
}
