<?php

namespace App\Filament\Resources\Panel\UserResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\Panel\UserResource;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
