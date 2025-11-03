<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
<<<<<<< HEAD
use Filament\Pages\Page;
use App\Models\Volunteer;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Infolists\Infolist;
=======
use App\Models\Volunteer;
use Filament\Tables\Table;
use Illuminate\Support\Str;
>>>>>>> c2aafa8681cabc998adb21c22e39ae68f307e8b2
use Filament\Resources\Resource;
use App\Enums\AvailabilityStatusEnum;
use App\Enums\VerificationStatusEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
<<<<<<< HEAD
use Filament\Support\Enums\FontWeight;
use Filament\Infolists\Components\Tabs;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\Group;
use Filament\Support\Enums\IconPosition;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Pages\SubNavigationPosition;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\Tabs\Tab;
use Filament\Forms\Components\ToggleButtons;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;
=======
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ToggleButtons;
>>>>>>> c2aafa8681cabc998adb21c22e39ae68f307e8b2
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\VolunteerResource\Pages;
use App\Filament\Admin\Resources\VolunteerResource\RelationManagers;

class VolunteerResource extends Resource
{
    protected static ?string $model = Volunteer::class;

    protected static ?string $navigationIcon = 'heroicon-o-face-smile';

<<<<<<< HEAD
    protected static ?string $modelLabel = 'Responder';

    // Change the plural model label
    protected static ?string $pluralModelLabel = 'Responders';

    // Change the slug (URL) - optional
    protected static ?string $slug = 'responders';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public function getHeading(): string
    {
        return 'Manage Responders';
    }

=======
>>>>>>> c2aafa8681cabc998adb21c22e39ae68f307e8b2
    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make()
                ->schema([

                    Select::make('user_id')
<<<<<<< HEAD
                    ->relationship(name: 'user', titleAttribute: 'name')
=======
                    ->relationship(name: 'user', titleAttribute: 'name', ignoreRecord: true)
>>>>>>> c2aafa8681cabc998adb21c22e39ae68f307e8b2
                    ->required()
                    ->searchable()
                    ->preload()
                    ->optionsLimit(6)
                    ->native(false)
                    ->getOptionLabelUsing(fn($record) => ucwords($record->name)),

                    Select::make('organization_id')
<<<<<<< HEAD
                    ->relationship(name: 'organization', titleAttribute: 'org_name')
=======
                    ->relationship(name: 'organization', titleAttribute: 'org_name', ignoreRecord: true)
>>>>>>> c2aafa8681cabc998adb21c22e39ae68f307e8b2
                    ->required()
                    ->searchable()
                    ->preload()
                    ->optionsLimit(6)
                    ->native(false),

                    ToggleButtons::make('availability_status')
                    ->options(AvailabilityStatusEnum::class)
                    ->inline()
                    ->default(AvailabilityStatusEnum::AVAILABLE)
                    ->dehydrated()
                    ->required(),

                    ToggleButtons::make('verification_status')
                    ->options(VerificationStatusEnum::class)
                    ->inline()
                    ->default(VerificationStatusEnum::PENDING)
                    ->dehydrated()
                    ->required(),

                    RichEditor::make('notes')
                    ->columnSpanFull()
                    ->maxLength(65535)
                    ->required(),

                ])
                ->columnSpan([
                    'sm' => 1,
                    'md' => 1,
                    'lg' => 3
                ]),

                Section::make()
                ->schema([
                    TextInput::make('certification_info.certification_name')
                    ->maxLength(255)
                    ->label(__('Certification Name')),

                    TextInput::make('certification_info.issuer')
                    ->maxLength(255)
                    ->label(__('Issuer')),

                    DatePicker::make('certification_info.issued_date')
                    ->native(false)
                    ->label(__('Issued Date'))
                    ->closeOnDateSelection(),

                    DatePicker::make('certification_info.expiration_date')
                    ->native(false)
                    ->label(__('Expiration Date'))
                    ->closeOnDateSelection(),
                ])
                ->columnSpan([
                    'sm' => 1,
                    'md' => 1,
                    'lg' => 2
                ])

            ])
            ->columns([
                'sm' => 1,
                'md' => 2,
                'lg' => 5
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                ->label(__('Name'))
                ->searchable()
                ->sortable()
                ->formatStateUsing(fn ($state) => ucwords($state))
                ->description(fn ($state, $record): string => $record->user->email),

                Tables\Columns\TextColumn::make('organization.org_name')
                ->label(__('Organization'))
                ->searchable()
                ->sortable()
                ->formatStateUsing(fn ($state) => ucwords($state)),

                Tables\Columns\TextColumn::make('availability_status')
                ->label(__('Availability'))
                ->icon(fn ($state): string => match ($state) {
                    AvailabilityStatusEnum::AVAILABLE->value => 'heroicon-o-check-circle',
                    AvailabilityStatusEnum::BUSY->value => 'heroicon-o-arrow-path',
                    AvailabilityStatusEnum::UNAVAILABLE->value => 'heroicon-o-x-circle',
                })
                ->badge()
                ->color(fn ($state): string => match ($state) {
                    AvailabilityStatusEnum::AVAILABLE->value => 'success',
                    AvailabilityStatusEnum::BUSY->value => 'warning',
                    AvailabilityStatusEnum::UNAVAILABLE->value => 'danger',
                })
                ->formatStateUsing(fn ($state) => Str::upper(AvailabilityStatusEnum::from($state)->value)),

                Tables\Columns\TextColumn::make('verification_status')
                ->label(__('Verification'))
                ->icon(fn ($state): string => match ($state) {
                    VerificationStatusEnum::PENDING->value => 'heroicon-o-clock',
                    VerificationStatusEnum::VERIFIED->value => 'heroicon-o-check-circle',
                    VerificationStatusEnum::REJECTED->value => 'heroicon-o-x-circle',
                })
                ->badge()
                ->color(fn ($state): string => match ($state) {
                    VerificationStatusEnum::PENDING->value => 'warning',
                    VerificationStatusEnum::VERIFIED->value => 'success',
                    VerificationStatusEnum::REJECTED->value => 'danger',
                })
                ->formatStateUsing(fn ($state) => Str::upper(VerificationStatusEnum::from($state)->value)),

                Tables\Columns\ToggleColumn::make('is_active')
                ->label(__('Status')),

                Tables\Columns\TextColumn::make('notes')
                ->label(__('Notes'))
                ->toggleable(isToggledHiddenByDefault: true)
                ->limit(70)
                ->wrap()
                ->formatStateUsing(fn ($state) => Str::ucfirst($state)),

                Tables\Columns\TextColumn::make('created_at')
                ->label(__('Created At'))
                ->dateTime('F j, Y, g:i a')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),


            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                    ->slideOver(),
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
                ->label(__('New Volunteer')),
            ])
            ->emptyStateIcon('heroicon-o-face-smile')
            ->emptyStateHeading('No Volunteers are created')
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
            'index' => Pages\ListVolunteers::route('/'),
            'create' => Pages\CreateVolunteer::route('/create'),
            'edit' => Pages\EditVolunteer::route('/{record}/edit'),
<<<<<<< HEAD
            'view' => Pages\ViewVolunteer::route('/{record}'),
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            Pages\ViewVolunteer::class,
            Pages\EditVolunteer::class,
        ]);
    }


    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Tabs::make('Tabs')
                ->tabs([
                    Tab::make('Responder Details')
                        ->icon('heroicon-m-user')
                        ->schema([
                            Fieldset::make('')
                            ->schema([
                                TextEntry::make('user.name')
                                ->label(__('Responder'))
                                ->size(TextEntry\TextEntrySize::Large)
                                ->weight(FontWeight::Bold),

                                TextEntry::make('user.email')
                                ->label(__('Email'))
                                ->size(TextEntry\TextEntrySize::Large)
                                ->weight(FontWeight::Bold)
                                ->icon('heroicon-m-envelope')
                                ->iconColor('primary')
                                ->copyable(),

                                TextEntry::make('organization.org_name')
                                ->label(__('Organization'))
                                ->badge()
                                ->color('success'),

                                TextEntry::make('availability_status')
                                ->label(__('Availability'))
                                ->badge()
                                ->icon(fn ($state): string => match ($state) {
                                    AvailabilityStatusEnum::AVAILABLE->value => 'heroicon-o-check-circle',
                                    AvailabilityStatusEnum::BUSY->value => 'heroicon-o-arrow-path',
                                    AvailabilityStatusEnum::UNAVAILABLE->value => 'heroicon-o-x-circle',
                                })
                                ->color(fn ($state): string => match ($state) {
                                    AvailabilityStatusEnum::AVAILABLE->value => 'success',
                                    AvailabilityStatusEnum::BUSY->value => 'warning',
                                    AvailabilityStatusEnum::UNAVAILABLE->value => 'danger',
                                })
                                ->formatStateUsing(fn ($state) => Str::upper(AvailabilityStatusEnum::from($state)->value)),

                                TextEntry::make('verification_status')
                                ->label(__('Verification'))
                                ->badge()
                                ->icon(fn ($state): string => match ($state) {
                                    VerificationStatusEnum::PENDING->value => 'heroicon-o-clock',
                                    VerificationStatusEnum::VERIFIED->value => 'heroicon-o-check-circle',
                                    VerificationStatusEnum::REJECTED->value => 'heroicon-o-x-circle',
                                })
                                ->color(fn ($state): string => match ($state) {
                                    VerificationStatusEnum::PENDING->value => 'warning',
                                    VerificationStatusEnum::VERIFIED->value => 'success',
                                    VerificationStatusEnum::REJECTED->value => 'danger',
                                })
                                ->formatStateUsing(fn ($state) => Str::upper(VerificationStatusEnum::from($state)->value)),


                                TextEntry::make('notes')
                                ->label(__('Notes'))
                                ->placeholder('-')
                                ->markdown()
                                ->html()
                                ->formatStateUsing(fn ($state) => Str::ucfirst($state))
                                ->columnSpanFull(),


                            ]),
                        ]),
                    Tab::make('Info Details')
                        ->icon('heroicon-m-list-bullet')
                        ->schema([
                            Fieldset::make('')
                            ->relationship('user.profile')
                            ->schema([
                                TextEntry::make('phone')
                                ->label(__('Phone'))
                                ->placeholder('-')
                                ->icon('heroicon-o-phone'),

                                TextEntry::make('emergency_contact')
                                ->label(__('Emergency Contact'))
                                ->placeholder('-'),

                                TextEntry::make('emergency_contact_phone')
                                ->label(__('Emergency Contact Phone'))
                                ->placeholder('-')
                                ->icon('heroicon-o-phone'),

                                TextEntry::make('full_address')
                                ->label(__('Address'))
                                ->placeholder('-')
                                ->icon('heroicon-o-map-pin')
                                ->columnSpanFull(),
                            ])
                            ->columns([
                                'sm' => 1,
                                'md' => 3,
                                'lg' => 3
                            ])
                        ]),

                    Tab::make('Skills and Certifications')
                        ->icon('heroicon-m-check-badge')
                        ->schema([
                            Fieldset::make('')
                            ->schema([
                                RepeatableEntry::make('volunteerSkills')
                                ->label(__('Skills'))
                                ->placeholder('-')
                                ->schema([
                                    Group::make([
                                        TextEntry::make('skill.skill_name')
                                        ->label(__('Skill'))
                                        ->weight(FontWeight::Bold)
                                        ->placeholder('-'),

                                         TextEntry::make('proficiency_level')
                                        ->label(__('Proficiency Level'))
                                        ->placeholder('-'),

                                        TextEntry::make('certification_date')
                                        ->label(__('Certification Date'))
                                        ->placeholder('-'),

                                        TextEntry::make('expiration_date')
                                        ->label(__('Expiration Date'))
                                        ->placeholder('-'),
                                    ])
                                    ->columns([
                                        'sm' => 1,
                                        'md' => 2,
                                        'lg' => 2
                                    ])
                                ]),

                                RepeatableEntry::make('certifications')
                                ->label(__('Certificates'))
                                ->placeholder('-')
                                ->schema([
                                    Group::make([
                                        TextEntry::make('name')
                                        ->label(__('Certificate'))
                                        ->weight(FontWeight::Bold)
                                        ->placeholder('-')
                                        ->columnSpanFull(),

                                        TextEntry::make('issued_at')
                                        ->label(__('Issued Date'))
                                        ->placeholder('-')
                                        ->date()
                                        ->badge()
                                        ->color('success'),

                                        TextEntry::make('expires_at')
                                        ->label(__('Expiration Date'))
                                        ->placeholder('-')
                                        ->date()
                                        ->badge()
                                        ->color('danger'),

                                        TextEntry::make('issuer')
                                        ->label(__('Issuer'))
                                        ->placeholder('-')
                                        ->columnSpanFull(),
                                    ])
                                    ->columns([
                                        'sm' => 1,
                                        'md' => 2,
                                        'lg' => 2
                                    ])
                                ])
                            ])
                            ->columns([
                                'sm' => 1,
                                'md' => 2,
                                'lg' => 2
                            ])
                        ])
                ])
                ->contained(false)
                ->columnSpanFull()


            ]);
    }
=======
        ];
    }
>>>>>>> c2aafa8681cabc998adb21c22e39ae68f307e8b2
}
