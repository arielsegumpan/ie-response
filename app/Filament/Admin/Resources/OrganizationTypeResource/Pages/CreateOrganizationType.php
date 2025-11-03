<?php

namespace App\Filament\Admin\Resources\OrganizationTypeResource\Pages;

use App\Filament\Admin\Resources\OrganizationTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOrganizationType extends CreateRecord
{
    protected static string $resource = OrganizationTypeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
