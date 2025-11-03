<?php

namespace App\Filament\Admin\Resources\VolunteerResource\Pages;

use App\Filament\Admin\Resources\VolunteerResource;
<<<<<<< HEAD
use App\Filament\Admin\Resources\VolunteerResource\Widgets\ResponderTableOverview;
=======
>>>>>>> c2aafa8681cabc998adb21c22e39ae68f307e8b2
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVolunteers extends ListRecords
{
    protected static string $resource = VolunteerResource::class;

    protected function getHeaderActions(): array
    {
        return [
<<<<<<< HEAD
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
=======
            Actions\CreateAction::make()->icon('heroicon-m-plus')->label(__('New Volunteer')),
>>>>>>> c2aafa8681cabc998adb21c22e39ae68f307e8b2
        ];
    }
}
