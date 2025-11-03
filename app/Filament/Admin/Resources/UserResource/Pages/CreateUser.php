<?php

namespace App\Filament\Admin\Resources\UserResource\Pages;

use Filament\Actions;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Admin\Resources\UserResource;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
         $data['email'] = Str::lower($data['email']);
        // Combine f_name and l_name into name field
        if (isset($data['f_name']) && isset($data['l_name'])) {
            $data['name'] = Str::ucfirst($data['f_name'] . ' ' . $data['l_name']);
        }
        // Remove f_name and l_name from users table data
        unset($data['f_name'], $data['l_name']);
        return $data;
    }


    protected function afterCreate(): void
    {
        $user = $this->record;
        // If user is responder, create profile
        if ($user->hasRole('responder')) {
            $user->profile()->create([
                'first_name' => Str::ucfirst(strip_tags($this->data['f_name'])) ?? null,
                'last_name' => Str::ucfirst(strip_tags($this->data['l_name'])) ?? null,
            ]);
        }
    }
}
