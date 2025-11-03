<?php

namespace App\Filament\Admin\Resources\UserResource\Pages;

use App\Filament\Admin\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
<<<<<<< HEAD


    protected function mutateFormDataBeforeFill(array $data): array
    {
        $user = $this->record;

        // Populate f_name and l_name based on role
        if ($user->hasRole('super_admin')) {
            // Split name for super_admin
            $nameParts = explode(' ', $user->name, 2);
            $data['f_name'] = $nameParts[0] ?? '';
            $data['l_name'] = $nameParts[1] ?? '';
        } else {
            // Get from profile for responder
            $data['f_name'] = $user->profile?->first_name ?? '';
            $data['l_name'] = $user->profile?->last_name ?? '';
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Combine f_name and l_name into name field
        if (isset($data['f_name']) && isset($data['l_name'])) {
            $data['name'] = $data['f_name'] . ' ' . $data['l_name'];
        }

        // Remove f_name and l_name from users table data
        unset($data['f_name'], $data['l_name']);

        return $data;
    }

    protected function afterSave(): void
    {
        $user = $this->record;

        // If user is responder, save to profile
        if ($user->hasRole('responder')) {
            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'first_name' => $this->data['f_name'],
                    'last_name' => $this->data['l_name'],
                ]
            );
        }
    }

=======
>>>>>>> c2aafa8681cabc998adb21c22e39ae68f307e8b2
}
