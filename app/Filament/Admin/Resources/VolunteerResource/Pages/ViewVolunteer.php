<?php

namespace App\Filament\Admin\Resources\VolunteerResource\Pages;

use App\Filament\Admin\Resources\VolunteerResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewVolunteer extends ViewRecord
{
    protected static string $resource = VolunteerResource::class;

    public static function getNavigationLabel(): string
    {
        return 'View Responder';
    }
}
