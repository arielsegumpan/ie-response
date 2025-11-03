<?php

namespace App\Filament\Admin\Resources\SkillCategoryResource\Pages;

use App\Filament\Admin\Resources\SkillCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSkillCategory extends EditRecord
{
    protected static string $resource = SkillCategoryResource::class;

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
