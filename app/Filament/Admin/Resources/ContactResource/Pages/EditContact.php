<?php

namespace App\Filament\Admin\Resources\ContactResource\Pages;

use App\Filament\Admin\Resources\ContactResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContact extends EditRecord
{
    protected static string $resource = ContactResource::class;

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
        $data['first_name'] = ucwords($data['first_name']);
        $data['last_name'] = ucwords($data['last_name']);
        $data['subject'] = ucwords($data['subject']);
        $data['message'] = ucfirst($data['message']);
        return $data;
    }
=======
>>>>>>> c2aafa8681cabc998adb21c22e39ae68f307e8b2
}
