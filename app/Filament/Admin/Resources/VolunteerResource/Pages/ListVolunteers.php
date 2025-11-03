<?php

namespace App\Filament\Admin\Resources\VolunteerResource\Pages;

use App\Filament\Admin\Resources\VolunteerResource;
use App\Filament\Admin\Resources\VolunteerResource\Widgets\ResponderTableOverview;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVolunteers extends ListRecords
{
    protected static string $resource = VolunteerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->icon('heroicon-m-plus')->label(__('New Responder')),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return 'View Reponder';
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ResponderTableOverview::class,
        ];
    }
}
