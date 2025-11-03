<?php

namespace App\Filament\Admin\Resources\OrganizationTypeResource\Pages;

use App\Filament\Admin\Resources\OrganizationTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrganizationType extends EditRecord
{
    protected static string $resource = OrganizationTypeResource::class;

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
}
