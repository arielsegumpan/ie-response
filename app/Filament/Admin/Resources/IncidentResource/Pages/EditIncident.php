<?php

namespace App\Filament\Admin\Resources\IncidentResource\Pages;

use App\Filament\Admin\Resources\IncidentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIncident extends EditRecord
{
    protected static string $resource = IncidentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
<<<<<<< HEAD


    protected function mutateFormDataBeforeSave(array $data): array
    {
       
        return $data;
    }
=======
>>>>>>> c2aafa8681cabc998adb21c22e39ae68f307e8b2
}
