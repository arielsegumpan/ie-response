<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\OrganizationType;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\OrganizationTypeResource\Pages;
use App\Filament\Admin\Resources\OrganizationTypeResource\RelationManagers;

class OrganizationTypeResource extends Resource
{
    protected static ?string $model = OrganizationType::class;

    protected static ?string $navigationIcon = null;

    protected static ?string $navigationGroup = 'Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                ->schema([
                    TextInput::make('org_type_name')
                    ->required()
                    ->unique(OrganizationType::class, 'org_type_name', ignoreRecord: true)
                    ->label(__('Organization Type Name'))
                    ->maxLength(255),

                    Textarea::make('org_type_description')
                    ->label(__('Description'))
                    ->rows(6)
                    ->maxLength(1024)
                    ->columnSpanFull(),
                ])
                ->columnSpan([
                    'sm' => 1,
                    'md' => 1,
                    'lg' => 1
                ]),

                Section::make()
                ->schema([

                    FileUpload::make('org_type_img')
                    ->hiddenlabel()
                    ->image()
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '16:9',
                        '4:3',
                        '1:1',
                    ])

                ])->columnSpan([
                    'sm' => 1,
                    'md' => 1,
                    'lg' => 1
                ])
            ])
            ->columns([
                'sm' => 1,
                'md' => 2,
                'lg' => 2
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                ImageColumn::make('org_type_img')
                ->label(__(''))
                ->square(),

                TextColumn::make('org_type_name')
                ->label(__('Name'))
                ->searchable()
                ->sortable()
                ->formatStateUsing(fn ($state) => ucfirst($state)),

                TextColumn::make('org_type_description')
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
                ->label(__('New Organization Type')),
            ])
            ->emptyStateIcon('heroicon-o-rectangle-group')
            ->emptyStateHeading('No Organization Types are created')
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
            'index' => Pages\ListOrganizationTypes::route('/'),
            'create' => Pages\CreateOrganizationType::route('/create'),
            'edit' => Pages\EditOrganizationType::route('/{record}/edit'),
        ];
    }
}
