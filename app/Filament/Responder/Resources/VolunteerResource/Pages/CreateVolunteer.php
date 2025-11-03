<?php

namespace App\Filament\Responder\Resources\VolunteerResource\Pages;

use App\Filament\Responder\Resources\VolunteerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateVolunteer extends CreateRecord
{
    protected static string $resource = VolunteerResource::class;
}
