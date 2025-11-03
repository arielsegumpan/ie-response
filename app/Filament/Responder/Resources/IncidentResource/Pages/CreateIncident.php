<?php

namespace App\Filament\Responder\Resources\IncidentResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Responder\Resources\IncidentResource;

class CreateIncident extends CreateRecord
{
    protected static string $resource = IncidentResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['verified_by'] = auth()->id();
        return $data;
    }
}
