<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Organization;
use App\Models\OrganizationType;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Support\Enums\FontWeight;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists\Components\Section as InfoSection;
use App\Filament\Admin\Resources\OrganizationResource\Pages;
use App\Filament\Admin\Resources\OrganizationResource\RelationManagers;

class OrganizationResource extends Resource
{
    protected static ?string $model = Organization::class;

   protected static ?string $navigationIcon = 'heroicon-o-globe-europe-africa';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make()
                ->schema([

                    TextInput::make('org_name')
                    ->required()
                    ->unique(Organization::class, 'org_name', ignoreRecord: true)
                    ->label(__('Organization Name'))
                    ->maxLength(255),

                    Select::make('organization_type_id')
                    ->relationship(name: 'organizationType', titleAttribute: 'org_type_name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->optionsLimit(6)
                    ->native(false)
                    ->createOptionForm([
                        Group::make([
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
                        ])

                    ]),

                    TextInput::make('org_email')
                    ->required()
                    ->unique(Organization::class, 'org_email', ignoreRecord: true)
                    ->label(__('Organization Email'))
                    ->maxLength(255),

                    TextInput::make('org_contact_person')
                    ->required()
                    ->label(__('Contact Person'))
                    ->maxLength(255),

                    TextInput::make('org_contact_phone')
                    ->required()
                    ->label(__('Contact Number'))
                    ->numeric()
                    ->placeholder('098765432123')
                    ->maxLength(12)
                    ->columnSpanFull(),

                    Textarea::make('org_description')
                    ->label(__('Description'))
                    ->rows(6)
                    ->maxLength(1024)
                    ->columnSpanFull(),

                ])
                ->columns([
                    'sm' => 1,
                    'md' => 2,
                    'lg' => 2
                ])
                ->columnSpan([
                    'sm' => 1,
                    'md' => 3,
                    'lg' => 3
                ]),

                Section::make()
                ->schema([
                    FileUpload::make('org_img')
                    ->hiddenlabel()
                    ->image()
                    ->imageEditor(),
                ])
                ->columnSpan([
                    'sm' => 1,
                    'md' => 2,
                    'lg' => 2
                ]),
            ])
            ->columns([
                'sm' => 1,
                'md' => 5,
                'lg' => 5
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                ImageColumn::make('org_img')
                ->label(__(''))
                ->square(),

                TextColumn::make('org_name')
                ->label(__('Organization Name'))
                ->searchable()
                ->sortable()
                ->formatStateUsing(fn ($state) => ucwords($state))
                ->description(fn ($state, $record): string => $record->org_email),

                TextColumn::make('org_contact_person')
                ->label(__('Contact Person'))
                ->searchable()
                ->sortable()
                ->formatStateUsing(fn ($state) => ucwords($state)),

                TextColumn::make('org_contact_phone')
                ->icon('heroicon-o-phone')
                ->label(__('Contact Number'))
                ->searchable()
                ->sortable()
                ->formatStateUsing(fn ($state) => $state),


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
                ->label(__('New Organization')),
            ])
            ->emptyStateIcon('heroicon-o-globe-europe-africa')
            ->emptyStateHeading('No Organizations are created')
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
            'index' => Pages\ListOrganizations::route('/'),
            'create' => Pages\CreateOrganization::route('/create'),
            'edit' => Pages\EditOrganization::route('/{record}/edit'),
        ];
    }


    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfoSection::make()
                ->schema([

                    TextEntry::make('org_name')
                    ->label(__('Organization Name'))
                    ->size(TextEntry\TextEntrySize::Large)
                    ->weight(FontWeight::Bold)
                    ->columnSpanFull(),

                    TextEntry::make('org_email')
                    ->label(__('Organization Email'))

                ])
                ->columns([
                    'sm' => 1,
                    'md' => 2,
                    'lg' => 2
                ])
                ->columnSpan([
                    'sm' => 1,
                    'md' => 3,
                    'lg' => 3
                ]),

                InfoSection::make()
                ->schema([
                    ImageEntry::make('org_img')
                    ->label('')
                    ->placeholder('No Image')
                ])
                ->columnSpan([
                    'sm' => 1,
                    'md' => 2,
                    'lg' => 2
                ]),
            ])
            ->columns([
                'sm' => 1,
                'md' => 5,
                'lg' => 5
            ]);
    }
}
