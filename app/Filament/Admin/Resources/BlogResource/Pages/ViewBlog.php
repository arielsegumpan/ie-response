<?php

namespace App\Filament\Admin\Resources\BlogResource\Pages;

use Filament\Actions;
use App\Filament\Admin\Resources\BlogResource;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewBlog extends ViewRecord
{
    protected static string $resource = BlogResource::class;

    public function getTitle(): string | Htmlable
    {
        /** @var Blog */
        $record = $this->getRecord();
        return $record->title;
    }

    protected function getActions(): array
    {
        return [];
    }
}
