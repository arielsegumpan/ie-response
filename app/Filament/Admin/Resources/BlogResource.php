<?php

namespace App\Filament\Admin\Resources;

use App\Models\Tag;
use Filament\Forms;
use App\Models\Blog;
use Filament\Tables;
use Filament\Forms\Set;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Resources\Pages\Page;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Support\Enums\FontWeight;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Pages\SubNavigationPosition;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ToggleButtons;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\KeyValueEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\BlogResource\Pages;
use Filament\Infolists\Components\Group as InfoGroup;
use Filament\Infolists\Components\Section as InfoSection;
use App\Filament\Admin\Resources\BlogResource\RelationManagers;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;

    protected static ?string $navigationIcon = null;

    protected static ?string $navigationGroup = 'Posts';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make([
                    'sm' => 1,
                    'md' => 4,
                    'lg' => 5,
                ])
                ->schema([
                    Section::make([
                        Hidden::make('user_id')
                        ->default(auth()->user()->id)
                        ->dehydrated(),

                        TextInput::make('title')
                        ->label(__('Title'))
                        ->required()
                        ->maxLength(255)
                        ->placeholder(__('Title of your blog post'))
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                        TextInput::make('slug')
                        ->label(__('Slug'))
                        ->disabled()
                        ->dehydrated()
                        ->required()
                        ->maxLength(255)
                        ->unique(Blog::class, 'slug', ignoreRecord: true),

                        RichEditor::make('content')
                        ->label(__('Content'))
                        ->required()
                        ->placeholder(__('The content of your blog'))
                        ->maxLength(4294967295),
                    ])
                    ->columnSpan([
                        'sm' => 1,
                        'md' => 2,
                        'lg' => 3,
                    ]),

                    Group::make([
                        Section::make()
                        ->schema([
                            FileUpload::make('featured_img')
                            ->label(__('Featured Image'))
                            ->image()
                            ->hiddenLabel()
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                null,
                                '16:9',
                                '4:3',
                            ])->maxSize(2048)
                            ->columnSpanFull(),


                            Select::make('categories')
                            ->label(__('Categories'))
                            ->multiple()
                            ->relationship(name: 'categories', titleAttribute: 'cat_name')
                            ->preload()
                            ->searchable()
                            ->placeholder(__('Select categories'))
                            ->optionsLimit(6)
                            ->native(false)
                            ->createOptionForm([
                                Group::make()
                                ->schema([
                                    TextInput::make('cat_name')
                                    ->required()
                                    ->label(__('Name'))
                                    ->placeholder(__('Category Name'))
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (Set $set, ?string $state) =>
                                        $set('cat_slug', Str::slug($state))),

                                    TextInput::make('cat_slug')
                                    ->label(__('Slug'))
                                    ->disabled()
                                    ->dehydrated()
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(Category::class, 'cat_slug', ignoreRecord: true),

                                    Textarea::make('cat_desc')
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
                            ]),

                            Select::make('tags')
                            ->label(__('Tags'))
                            ->multiple()
                            ->relationship(name: 'tags', titleAttribute: 'tag_name')
                            ->preload()
                            ->searchable()
                            ->placeholder(__('Select tags'))
                            ->optionsLimit(6)
                            ->native(false)
                            ->createOptionForm([
                                Group::make()
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
                            ]),

                            ToggleButtons::make('status')
                            ->label(__('Status'))
                            ->default('published')
                            ->dehydrated()
                            ->options([
                                'draft' => __('Draft'),
                                'published' => __('Published'),
                            ])
                            ->colors([
                                'draft' => 'warning',
                                'published' => 'success',
                            ])
                            ->icons([
                                'draft' => 'heroicon-o-pencil',
                                'published' => 'heroicon-o-check-circle',
                            ])
                            ->inline(),

                            ToggleButtons::make('is_featured')
                            ->label(__('Featured'))
                            ->default(0)
                            ->dehydrated()
                            ->options([
                                0 => __('No'),
                                1 => __('Yes'),
                            ])
                            ->colors([
                                0 => 'danger',
                                1 => 'success',
                            ])
                            ->icons([
                                0 => 'heroicon-o-x-circle',
                                1 => 'heroicon-o-check-circle',
                            ])
                            ->inline(),
                            ToggleButtons::make('is_visible')
                            ->label(__('Visible'))
                            ->default(1)
                            ->dehydrated()
                            ->options([
                                0 => __('No'),
                                1 => __('Yes'),
                            ])
                            ->colors([
                                0 => 'danger',
                                1 => 'success',
                            ])
                            ->icons([
                                0 => 'heroicon-o-x-circle',
                                1 => 'heroicon-o-check-circle',
                            ])
                            ->inline(),
                        ]),

                        Section::make()
                        ->schema([

                            TextInput::make('metadata.seo_title')
                            ->label(__('SEO Title'))
                            ->maxLength(255),

                            Textarea::make('metadata.seo_description')
                            ->label(__('SEO Description'))
                            ->rows(4)
                            ->maxLength(300),

                            TagsInput::make('metadata.seo_keywords')
                            ->label(__('SEO Keywords'))
                            ->separator(',')
                            ->reorderable()
                            ->color('danger')
                            ->nestedRecursiveRules([
                                'min:3',
                                'max:255',
                            ])

                        ]),


                    ])
                    ->columnSpan([
                        'sm' => 1,
                        'md' => 2,
                        'lg' => 2,
                    ]),
                ])
                ->columnSpanFull()

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('featured_img')
                ->label(__(''))
                ->square(),

                TextColumn::make('title')
                ->label(__('Title'))
                ->searchable()
                ->sortable()
                ->limit(50)
                ->description(fn (Blog $record) => $record->slug)
                ->size(TextColumn\TextColumnSize::Large)
                ->weight(FontWeight::Bold),

                TextColumn::make('status')
                ->label(__('Status'))
                ->icon(fn (string $state): string => match ($state) {
                    'draft' => 'heroicon-o-pencil',
                    'published' => 'heroicon-o-check-circle',
                })
                ->color(fn (string $state): string => match ($state) {
                    'draft' => 'warning',
                    'published' => 'success',
                })
                ->badge()
                ->formatStateUsing(fn (string $state): string => strtoupper($state))
                ->tooltip(fn (string $state): string => match ($state) {
                    'draft' => __('Draft'),
                    'published' => __('Published'),
                }),

                ToggleColumn::make('is_featured')
                ->label(__('Is Featured?')),

                ToggleColumn::make('is_visible')
                ->label(__('Is Visible'))
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
                ->label(__('New Blog')),
            ])
            ->emptyStateIcon('heroicon-o-pencil-square')
            ->emptyStateHeading('No Blogs are created')
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
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
            'view' => Pages\ViewBlog::route('/{record}'),
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            Pages\ViewBlog::class,
            Pages\EditBlog::class,
        ]);
    }


    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([

                InfoSection::make()
                ->schema([

                    InfoGroup::make([
                        ImageEntry::make('featured_img')
                        ->hiddenLabel()
                        ->width('100%')
                        ->height(200)
                        ->grow(false)
                        ->columnSpan([
                            'sm' => 1,
                            'md' => 1,
                            'lg' => 1,
                        ]),

                        InfoGroup::make([
                            TextEntry::make('title')
                            ->label(__('Title'))
                            ->size(TextEntry\TextEntrySize::Large)
                            ->weight(FontWeight::Bold),

                            TextEntry::make('slug')
                            ->label(__('Slug'))
                            ->badge()
                            ->color('primary')

                        ])
                        ->columnSpan([
                            'sm' => 1,
                            'md' => 1,
                            'lg' => 2,
                        ]),
                    ])
                    ->columns([
                        'sm' => 1,
                        'md' => 2,
                        'lg' => 3,
                    ]),
                ])
                ->columnSpanFull(),

                // status
                InfoSection::make()
                ->schema([
                    InfoGroup::make([
                        TextEntry::make('status')
                        ->label(__('Status'))
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'draft' => 'warning',
                            'published' => 'success',
                        })
                        ->icon(fn (string $state): string => match ($state) {
                            'draft' => 'heroicon-o-pencil',
                            'published' => 'heroicon-o-check-circle',
                        })
                        ->formatStateUsing(fn (string $state): string => strtoupper($state)),

                        TextEntry::make('is_featured')
                        ->label(__('Is featured on the homepage?'))
                        ->badge()
                        ->color(fn (int $state): string => match ($state) {
                            0 => 'danger',
                            1 => 'success',
                        })
                        ->icon(fn (int $state): string => match ($state) {
                            0 => 'heroicon-o-x-circle',
                            1 => 'heroicon-o-check-circle',
                        })
                        ->formatStateUsing(fn (int $state): string => match ($state) {
                            0 => __('No'),
                            1 => __('Yes'),
                        }),

                        TextEntry::make('is_visible')
                        ->label(__('Is visible to the public?'))
                        ->badge()
                        ->color(fn (int $state): string => match ($state) {
                            0 => 'danger',
                            1 => 'success',
                        })
                        ->icon(fn (int $state): string => match ($state) {
                            0 => 'heroicon-o-x-circle',
                            1 => 'heroicon-o-check-circle',
                        })
                        ->formatStateUsing(fn (int $state): string => match ($state) {
                            0 => __('No'),
                            1 => __('Yes'),
                        })
                    ])
                    ->columns([
                        'sm' => 1,
                        'md' => 3,
                        'lg' => 3,
                    ])
                    ->columnSpanFull(),

                    TextEntry::make('tags.tag_name')
                    ->badge()
                    ->separator(',')
                    ->label(__('Tags'))
                    ->color('warning')
                    ->columnSpan([
                        'sm' => 1,
                        'md' => 2,
                        'lg' => 2,
                    ])
                    ->placeholder(__('No tags assigned')),

                    TextEntry::make('categories.cat_name')
                    ->badge()
                    ->separator(',')
                    ->label(__('Categories'))
                    ->color('warning')
                    ->columnSpan([
                        'sm' => 1,
                        'md' => 2,
                        'lg' => 2,
                    ])
                    ->placeholder(__('No categories assigned')),
                ])
                ->columns([
                    'sm' => 1,
                    'md' => 4,
                    'lg' => 4,
                ]),
                // end of status

                // content
                InfoSection::make([
                    TextEntry::make('content')
                    ->hiddenlabel(__('Content'))
                    ->html()
                    ->columnSpanFull(),
                ])
                ->columns([
                    'sm' => 1,
                    'md' => 3,
                    'lg' => 3,
                ]),

                InfoSection::make('SEO')
                ->description(__('Search Engine Optimization (SEO)'))
                ->collapsible()
                ->schema([
                    KeyValueEntry::make('metadata')
                    ->label('')
                    ->keyLabel('Metadata')
                    ->valueLabel('Value'),

                ])
                ->columnSpanFull(),


            ]);
    }
}
