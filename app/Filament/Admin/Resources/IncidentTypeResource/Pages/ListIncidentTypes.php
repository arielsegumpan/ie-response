<?php

namespace App\Filament\Admin\Resources\IncidentTypeResource\Pages;

use App\Filament\Admin\Resources\IncidentTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIncidentTypes extends ListRecords
{
    protected static string $resource = IncidentTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->icon('heroicon-m-plus')->label(__('New Incident Type')),
        ];
    }
}
