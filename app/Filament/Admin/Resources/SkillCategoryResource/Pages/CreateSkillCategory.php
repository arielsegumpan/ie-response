<?php

namespace App\Filament\Admin\Resources\SkillCategoryResource\Pages;

use App\Filament\Admin\Resources\SkillCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSkillCategory extends CreateRecord
{
    protected static string $resource = SkillCategoryResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
