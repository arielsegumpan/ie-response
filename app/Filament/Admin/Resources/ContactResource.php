<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Contact;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ToggleButtons;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Forms\Components\DateTimePicker;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists\Components\Group as InfoGroup;
use Filament\Infolists\Components\Split as InfoSplit;
use App\Filament\Admin\Resources\ContactResource\Pages;
use Filament\Infolists\Components\Section as infoSection;
use App\Filament\Admin\Resources\ContactResource\RelationManagers;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-phone';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Split::make([
                    Group::make([
                        Section::make()
                        ->schema([
                            Group::make([
                                TextInput::make('first_name')
                                    ->label(__('First Name'))
                                    ->required(),
                                TextInput::make('last_name')
                                    ->label(__('Last Name'))
                                    ->required(),
                                TextInput::make('email')
                                    ->label(__('Email'))
                                    ->required()
                                    ->email(),
                            ])
                            ->columnspanFull()
                            ->columns([
                                'sm' => 1,
                                'md' => 3,
                                'lg' => 3,
                            ]),

                            TextInput::make('subject')
                                ->label(__('Subect'))
                                ->required(),

                            TextInput::make('phone')
                                ->label(__('Phone'))
                                ->required()
                        ])
                        ->columns([
                            'sm' => 1,
                            'md' => 2,
                            'lg' => 2,
                        ]),

                        Section::make()
                        ->schema([
                            Textarea::make('message')
                                ->label(__('Message'))
                                ->required()
                                ->rows(5)
                        ])
                    ]),

                    Section::make()
                    ->schema([
                        ToggleButtons::make('status')
                        ->options([
                            'new' => 'New',
                            'in_progress' => 'In Progress',
                            'resolved' => 'Resolved'
                        ])
                        ->colors([
                            'new' => 'info',
                            'in_progress' => 'warning',
                            'resolved' => 'success',
                        ])
                        ->icons([
                            'new' => 'heroicon-o-pencil',
                            'in_progress' => 'heroicon-o-clock',
                            'resolved' => 'heroicon-o-check-circle',
                        ])
                        ->default('new')
                        ->dehydrated()
                        ->inline(),

                        DateTimePicker::make('resolved_at')
                        ->seconds(false)
                        ->timezone('Asia/Manila')
                        ->native(false)

                    ])->grow(false)
                ])
                ->columnSpanFull()
                ->from('md')

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_name')
                    ->label(__('First Name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('last_name')
                    ->label(__('Last Name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->label(__('Phone'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label(__('Email'))
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-envelope')
                    ->badge()
                    ->color('primary'),
                TextColumn::make('subject')
                    ->label(__('Subject'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status')
                    ->label(__('Status'))
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('success'),
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
                ->label(__('New Contact')),
            ])
            ->emptyStateIcon('heroicon-o-phone')
            ->emptyStateHeading('No Contacts are created')
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
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }



    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfoSplit::make([
                    InfoGroup::make([
                        infoSection::make()
                        ->schema([
                            InfoGroup::make([
                                TextEntry::make('first_name')
                                    ->size(TextEntry\TextEntrySize::Large),
                                TextEntry::make('last_name')
                                    ->size(TextEntry\TextEntrySize::Large),
                                TextEntry::make('email')
                                    ->label(__('Email'))
                                    ->badge()
                                    ->color('primary')
                                    ->icon('heroicon-m-envelope'),
                            ])
                            ->columnspanFull()
                            ->columns([
                                'sm' => 1,
                                'md' => 3,
                                'lg' => 3,
                            ]),

                            TextEntry::make('subject')
                                ->label(__('Subect')),

                            TextEntry::make('phone')
                                ->label(__('Phone'))
                        ])
                        ->columns([
                            'sm' => 1,
                            'md' => 2,
                            'lg' => 2,
                        ]),

                        InfoSection::make()
                        ->schema([
                            TextEntry::make('message')
                            ->icon('heroicon-m-chat-bubble-bottom-center-text')
                        ])
                    ]),

                    InfoSection::make()
                    ->schema([
                        TextEntry::make('status')
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'new' => 'info',
                            'in_progress' => 'warning',
                            'resolved' => 'success',
                            default => 'gray',
                        })
                        ->icon(fn (string $state): string => match ($state) {
                            'new' => 'heroicon-o-pencil',
                            'in_progress' => 'heroicon-o-clock',
                            'resolved' => 'heroicon-o-check-circle',
                        }),

                        TextEntry::make('resolved_at')
                            ->label(__('Resolved At'))
                            ->dateTime()
                            ->placeholder(__('No date'))
                            ->icon('heroicon-m-calendar')
                    ])->grow(false)
                ])
                ->columnSpanFull()
                ->from('md')
            ]);
    }
}
