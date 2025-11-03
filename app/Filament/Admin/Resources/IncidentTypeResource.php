<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use App\Models\IncidentType;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\IncidentTypeResource\Pages;
use App\Filament\Admin\Resources\IncidentTypeResource\RelationManagers;

class IncidentTypeResource extends Resource
{
    protected static ?string $model = IncidentType::class;

    protected static ?string $navigationIcon = null;

    protected static ?string $navigationGroup = 'Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                ->schema([

                    TextInput::make('inc_name')
                    ->required()
                    ->label(__('Incident Name'))
                    ->unique(IncidentType::class, 'inc_name', ignoreRecord: true)
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) =>
                        $set('inc_slug', Str::slug($state))),

                    TextInput::make('inc_slug')
                    ->label(__('Slug'))
                    ->disabled()
                    ->dehydrated()
                    ->required()
                    ->maxLength(255)
                    ->unique(IncidentType::class, 'inc_slug', ignoreRecord: true),

                    Textarea::make('inc_description')
                    ->label(__('Description'))
                    ->rows(5)
                    ->maxLength(1024)
                    ->columnSpanFull(),

                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('inc_name')
                ->label(__('Name'))
                ->searchable()
                ->sortable()
                ->formatStateUsing(fn ($state) => ucfirst($state)),

                TextColumn::make('inc_description')
                ->label(__('Description'))
                ->limit(70)
                ->wrap()
                ->formatStateUsing(fn ($state) => ucfirst($state))
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                ->slideOver()
                ->stickyModalFooter(),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])->tooltip('Actions')
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->deferLoading()
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                ->icon('heroicon-m-plus')
                ->label(__('New Incident Type')),
            ])
            ->emptyStateIcon('heroicon-o-lifebuoy')
            ->emptyStateHeading('No Incident Types are created')
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIncidentTypes::route('/'),
            'create' => Pages\CreateIncidentType::route('/create'),
            'edit' => Pages\EditIncidentType::route('/{record}/edit'),
        ];
    }
}
