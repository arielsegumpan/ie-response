<?php

<<<<<<<< HEAD:app/Filament/Responder/Resources/IncidentResource/Pages/ListIncidents.php
namespace App\Filament\Responder\Resources\IncidentResource\Pages;

use App\Filament\Responder\Resources\IncidentResource;
========
namespace App\Filament\Admin\Resources\IncidentResource\Pages;

use App\Filament\Admin\Resources\IncidentResource;
>>>>>>>> c2aafa8681cabc998adb21c22e39ae68f307e8b2:app/Filament/Admin/Resources/IncidentResource/Pages/ListIncidents.php
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIncidents extends ListRecords
{
    protected static string $resource = IncidentResource::class;

    protected function getHeaderActions(): array
    {
        return [
<<<<<<<< HEAD:app/Filament/Responder/Resources/IncidentResource/Pages/ListIncidents.php
            Actions\CreateAction::make(),
========
            Actions\CreateAction::make()->icon('heroicon-o-plus')->label('New Incident'),
>>>>>>>> c2aafa8681cabc998adb21c22e39ae68f307e8b2:app/Filament/Admin/Resources/IncidentResource/Pages/ListIncidents.php
        ];
    }
}
