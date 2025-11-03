<?php

namespace App\Filament\Admin\Resources\IncidentTypeResource\Pages;

use Filament\Actions;
use Illuminate\Support\Str;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Admin\Resources\IncidentTypeResource;

class CreateIncidentType extends CreateRecord
{
    protected static string $resource = IncidentTypeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['inc_name'] = Str::ucwords($data['inc_name']);

        return $data;
    }
}
