<?php

namespace App\Filament\Admin\Resources\SkillCategoryResource\Pages;

use App\Filament\Admin\Resources\SkillCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSkillCategories extends ListRecords
{
    protected static string $resource = SkillCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->icon('heroicon-m-plus')->label(__('New Skill Category')),
        ];
    }
}
