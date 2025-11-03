<?php

namespace App\Filament\Admin\Resources\VolunteerResource\Pages;

use App\Filament\Admin\Resources\VolunteerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVolunteer extends EditRecord
{
    protected static string $resource = VolunteerResource::class;

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

    public static function getNavigationLabel(): string
    {
        return 'Edit Responder';
    }
}
