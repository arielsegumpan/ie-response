<?php

namespace App\Filament\Admin\Resources;

use App\Models\Tag;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Support\Enums\FontWeight;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Admin\Resources\TagResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\TagResource\RelationManagers;

class TagResource extends Resource
{
    protected static ?string $model = Tag::class;

    protected static ?string $navigationIcon = null;

    protected static ?string $navigationGroup = 'Posts';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make()
                ->schema([
                    TextInput::make('tag_name')
                    ->required()
                    ->label(__('Name'))
                    ->placeholder(__('Tag Name'))
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) =>
                        $set('tag_slug', Str::slug($state))),

                    TextInput::make('tag_slug')
                    ->label(__('Slug'))
                    ->disabled()
                    ->dehydrated()
                    ->required()
                    ->maxLength(255)
                    ->unique(Tag::class, 'tag_slug', ignoreRecord: true),

                    Textarea::make('tag_desc')
                    ->label(__('Description'))
                    ->rows(5)
                    ->placeholder(__('Description'))
                    ->maxLength(1024)
                    ->columnSpanFull()
                ])
                ->columns([
                    'sm' => 1,
                    'md' => 2,
                    'lg' => 2,
                ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tag_name')
                    ->label(__('Name'))
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Bold)
                    ->formatStateUsing(fn ($state) => ucwords($state)),

                TextColumn::make('tag_slug')
                    ->label(__('Slug'))
                    ->badge()
                    ->color('primary'),

                TextColumn::make('tag_desc')
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
                ->label(__('New Tag')),
            ])
            ->emptyStateIcon('heroicon-o-hashtag')
            ->emptyStateHeading('No Tags are created')
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
            'index' => Pages\ListTags::route('/'),
            'create' => Pages\CreateTag::route('/create'),
            'edit' => Pages\EditTag::route('/{record}/edit'),
        ];
    }
}
