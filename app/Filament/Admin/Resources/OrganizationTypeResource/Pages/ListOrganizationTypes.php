<?php

namespace App\Filament\Admin\Resources\OrganizationTypeResource\Pages;

use App\Filament\Admin\Resources\OrganizationTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOrganizationTypes extends ListRecords
{
    protected static string $resource = OrganizationTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->icon('heroicon-m-plus')->label(__('New Organization Type')),
        ];
    }
}
