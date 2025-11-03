<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\SkillCategory;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\SkillCategoryResource\Pages;
use App\Filament\Admin\Resources\SkillCategoryResource\RelationManagers;

class SkillCategoryResource extends Resource
{
    protected static ?string $model = SkillCategory::class;

    protected static ?string $navigationIcon = null;

    protected static ?string $navigationGroup = 'Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make()
                ->schema([
                    TextInput::make('skill_cat_name')
                    ->label('Skill Category Name')
                    ->required()
                    ->unique(SkillCategory::class, 'skill_cat_name', ignoreRecord: true)
                    ->maxLength(255),

                    Textarea::make('skill_cat_description')
                    ->label('Description')
                    ->rows(6)
                    ->maxLength(1024)
                    ->columnSpanFull(),
                ])


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('skill_cat_name')
                ->label(__('Name'))
                ->searchable()
                ->sortable()
                ->formatStateUsing(fn ($state) => ucwords($state)),

                TextColumn::make('skill_cat_description')
                ->label(__('Description'))
                ->limit(70)
                ->wrap()
                ->formatStateUsing(fn ($state) => ucfirst($state))
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
                ->label(__('New Skill Category')),
            ])
            ->emptyStateIcon('heroicon-o-wrench-screwdriver')
            ->emptyStateHeading('No Skill Categories are created')
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
            'index' => Pages\ListSkillCategories::route('/'),
            'create' => Pages\CreateSkillCategory::route('/create'),
            'edit' => Pages\EditSkillCategory::route('/{record}/edit'),
        ];
    }
}
