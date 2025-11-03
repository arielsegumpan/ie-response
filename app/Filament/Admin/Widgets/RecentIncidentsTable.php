<?php

namespace App\Filament\Admin\Widgets;

use Filament\Tables;
use App\Models\Incident;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentIncidentsTable extends BaseWidget
{
    protected static ?int $sort = 6;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Incident::query()
                    ->with(['reporter', 'type'])
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('incident_number')
                    ->label('Incident #')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('type.inc_name')
                    ->label('Type')
                    ->searchable(),

                Tables\Columns\TextColumn::make('status')
                ->label('Status')
                ->sortable()
                ->searchable()
                ->formatStateUsing(fn ($state) => ucwords($state))
                ->weight(FontWeight::Bold)
                ->badge()
                ->color(function (string $state): string {
                    return match ($state) {
                        'reported' => 'warning',
                        'verified' => 'info',
                        'in_progress' => 'warning',
                        'resolved' => 'success',
                        'closed' => 'danger',
                        default => 'secondary',
                    };
                })
                ->icon(function (string $state): string {
                    return match ($state) {
                        'reported' => 'heroicon-s-flag',
                        'verified' => 'heroicon-s-check-circle',
                        'in_progress' => 'heroicon-s-arrow-path',
                        'resolved' => 'heroicon-s-check-circle',
                        'closed' => 'heroicon-s-x-circle',
                        default => 'heroicon-s-clock',
                    };
                })
                ->formatStateUsing(fn ($state) => Str::replace('_', ' ', ucwords($state))),

                Tables\Columns\TextColumn::make('priority')
                ->label('Priority')
                ->sortable()
                ->searchable()
                ->formatStateUsing(fn ($state) => ucwords($state))
                ->weight(FontWeight::Bold)
                ->badge()
                ->color(function (string $state): string {
                    return match ($state) {
                        'low' => 'success',
                        'medium' => 'warning',
                        'high' => 'danger',
                        'critical' => 'danger',
                    };
                })
                ->icon(function (string $state): string {
                    return match ($state) {
                        'low' => 'heroicon-o-arrow-trending-down',
                        'medium' => 'heroicon-o-arrows-right-left',
                        'high' => 'heroicon-o-arrow-trending-up',
                        'critical' => 'heroicon-o-arrow-trending-up',
                    };
                }),

                Tables\Columns\TextColumn::make('reporter.name')
                    ->label('Reporter')
                    ->placeholder('Citizen')
                    ->icon('heroicon-s-user')
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Reported')
                    ->dateTime()
                    ->sortable(),
            ]);
    }
}
