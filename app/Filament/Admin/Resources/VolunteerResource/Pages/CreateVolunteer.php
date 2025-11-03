<?php

namespace App\Filament\Admin\Resources\VolunteerResource\Pages;

<<<<<<< HEAD
=======
use App\Filament\Admin\Resources\VolunteerResource;
>>>>>>> c2aafa8681cabc998adb21c22e39ae68f307e8b2
use Filament\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Admin\Resources\VolunteerResource;

class CreateVolunteer extends CreateRecord
{
    protected static string $resource = VolunteerResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public static function getNavigationLabel(): string
    {
        return 'Create Responder';
    }
}
