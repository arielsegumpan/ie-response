<?php

namespace App\Filament\Responder\Pages;

use App\Models\User;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Forms\Components\Tabs;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Cache;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use App\Traits\HandlesCascadingAddress;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Woenel\Prpcmblmts\Models\PhilippineCity;
use Woenel\Prpcmblmts\Models\PhilippineRegion;
use Filament\Forms\Concerns\InteractsWithForms;
use Woenel\Prpcmblmts\Models\PhilippineBarangay;
use Woenel\Prpcmblmts\Models\PhilippineProvince;

class EditProfile extends Page implements HasForms
{
    use InteractsWithForms, HandlesCascadingAddress;

    protected static string $view = 'filament.responder.pages.edit-profile';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'email' => auth()->user()->email,
            'first_name' => auth()->user()->profile?->first_name,
            'last_name' => auth()->user()->profile?->last_name,
            'phone' => auth()->user()->profile?->phone,
            'emergency_contact' => auth()->user()->profile?->emergency_contact,
            'emergency_contact_phone' => auth()->user()->profile?->emergency_contact_phone,
            'full_address' => auth()->user()->profile?->full_address,
            'region_id' => auth()->user()->profile?->region_id,
            'province_id' => auth()->user()->profile?->province_id,
            'city_id' => auth()->user()->profile?->city_id,
            'barangay_id' => auth()->user()->profile?->barangay_id,
            'street_address' => auth()->user()->profile?->street,
        ]);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Tabs::make('Tabs')
                ->tabs([
                    Tabs\Tab::make('Profile')
                        ->icon('heroicon-m-user')
                        ->schema([
                            Section::make()
                            ->icon('heroicon-o-user')
                            ->description('Update your profile details.')
                            ->schema([
                                Fieldset::make('User details')
                                ->schema([
                                    TextInput::make('first_name')
                                    ->required()
                                    ->maxLength(255),

                                    TextInput::make('last_name')
                                    ->required()
                                    ->maxLength(255),

                                    TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                    TextInput::make('password')
                                    ->password()
                                    ->revealable()
                                    ->minLength(8)
                                    ->maxLength(255)
                                    ->dehydrated(fn ($state) => filled($state))
                                    ->helperText('Leave blank to keep current password'),

                                    TextInput::make('password_confirmation')
                                    ->password()
                                    ->revealable()
                                    ->minLength(8)
                                    ->maxLength(255)
                                    ->dehydrated(false)
                                    ->requiredWith('password')
                                    ->same('password')
                                    ->helperText('Confirm your new password'),
                                ])
                                ->columns([
                                    'sm' => 1,
                                    'md' => 2,
                                    'lg' => 2
                                ]),
                            ]),

                            Section::make()
                            ->icon('heroicon-o-phone')
                            ->description('Update your contact details.')
                            ->schema([
                                Fieldset::make('User contacts')
                                ->schema([
                                    TextInput::make('phone')
                                    ->required()
                                    ->maxLength(12)
                                    ->regex('/^(\+63|0)\d{10}$/')
                                    ->prefixIcon('heroicon-o-device-phone-mobile')
                                    ->helperText('e.g +639123456789'),

                                    TextInput::make('emergency_contact')
                                    ->required()
                                    ->maxLength(255)
                                    ->prefixIcon('heroicon-o-user')
                                    ->helperText('e.g John Doe'),

                                    TextInput::make('emergency_contact_phone')
                                    ->required()
                                    ->maxLength(12)
                                    ->prefixIcon('heroicon-o-phone')
                                    ->helperText('e.g 0212345678'),
                                ])
                                ->columns([
                                    'sm' => 1,
                                    'md' => 3,
                                    'lg' => 3
                                ])
                            ]),
                        ]),
                    Tabs\Tab::make('Address')
                        ->icon('heroicon-m-map-pin')
                        ->schema([
                            Section::make()
                            ->icon('heroicon-o-map-pin')
                            ->description('Update your address.')
                            ->schema([
                                Fieldset::make('User address')
                                ->schema([
                                    // Region Select
                                    Select::make('region_id')
                                        ->label('Region')
                                        ->required()
                                        ->searchable()
                                        ->preload()
                                        ->optionsLimit(50)
                                        ->native(false)
                                        ->live()
                                        ->options(function () {
                                            return Cache::remember('philippine_regions_options', 3600, function () {
                                                return PhilippineRegion::select('id', 'name')
                                                    ->orderBy('name')
                                                    ->pluck('name', 'id')
                                                    ->toArray();
                                            });
                                        })
                                        ->getSearchResultsUsing(function (string $search): array {
                                            return PhilippineRegion::where('name', 'like', "%{$search}%")
                                                ->limit(50)
                                                ->pluck('name', 'id')
                                                ->toArray();
                                        })
                                        ->getOptionLabelUsing(fn ($value): ?string =>
                                            Cache::remember("region_label_{$value}", 1800, function () use ($value) {
                                                return PhilippineRegion::find($value)?->name;
                                            })
                                        )
                                        ->afterStateUpdated(function (Set $set, Get $get) {
                                            $set('province_id', null);
                                            $set('city_id', null);
                                            $set('barangay_id', null);
                                            static::updateFullAddress($set, $get);
                                        }),

                                    // Province Select
                                    Select::make('province_id')
                                        ->label('Province')
                                        ->required()
                                        ->searchable()
                                        ->optionsLimit(50)
                                        ->native(false)
                                        ->live()
                                        ->options(function (Get $get) {
                                            $regionId = $get('region_id');
                                            if (!$regionId) {
                                                return [];
                                            }

                                            return Cache::remember("provinces_for_region_{$regionId}", 1800, function () use ($regionId) {
                                                $region = PhilippineRegion::find($regionId);
                                                if (!$region) {
                                                    return [];
                                                }

                                                return PhilippineProvince::where('region_code', $region->code)
                                                    ->orderBy('name')
                                                    ->pluck('name', 'id')
                                                    ->toArray();
                                            });
                                        })
                                        ->getSearchResultsUsing(function (string $search, Get $get): array {
                                            $regionId = $get('region_id');
                                            if (!$regionId) {
                                                return [];
                                            }

                                            $region = PhilippineRegion::find($regionId);
                                            if (!$region) {
                                                return [];
                                            }

                                            return PhilippineProvince::where('region_code', $region->code)
                                                ->where('name', 'like', "%{$search}%")
                                                ->limit(50)
                                                ->pluck('name', 'id')
                                                ->toArray();
                                        })
                                        ->getOptionLabelUsing(fn ($value): ?string =>
                                            Cache::remember("province_label_{$value}", 1800, function () use ($value) {
                                                return PhilippineProvince::find($value)?->name;
                                            })
                                        )
                                        ->afterStateUpdated(function (Set $set, Get $get) {
                                            $set('city_id', null);
                                            $set('barangay_id', null);
                                            static::updateFullAddress($set, $get);
                                        })
                                        ->visible(fn (Get $get): bool => filled($get('region_id'))),

                                    // City Select
                                    Select::make('city_id')
                                        ->label('City/Municipality')
                                        ->required()
                                        ->searchable()
                                        ->optionsLimit(50)
                                        ->native(false)
                                        ->live()
                                        ->options(function (Get $get) {
                                            $provinceId = $get('province_id');
                                            if (!$provinceId) {
                                                return [];
                                            }

                                            return Cache::remember("cities_for_province_{$provinceId}", 1800, function () use ($provinceId) {
                                                $province = PhilippineProvince::find($provinceId);
                                                if (!$province) {
                                                    return [];
                                                }

                                                return PhilippineCity::where('province_code', $province->code)
                                                    ->orderBy('name')
                                                    ->pluck('name', 'id')
                                                    ->toArray();
                                            });
                                        })
                                        ->getSearchResultsUsing(function (string $search, Get $get): array {
                                            $provinceId = $get('province_id');
                                            if (!$provinceId) {
                                                return [];
                                            }

                                            $province = PhilippineProvince::find($provinceId);
                                            if (!$province) {
                                                return [];
                                            }

                                            return PhilippineCity::where('province_code', $province->code)
                                                ->where('name', 'like', "%{$search}%")
                                                ->limit(50)
                                                ->pluck('name', 'id')
                                                ->toArray();
                                        })
                                        ->getOptionLabelUsing(fn ($value): ?string =>
                                            Cache::remember("city_label_{$value}", 1800, function () use ($value) {
                                                return PhilippineCity::find($value)?->name;
                                            })
                                        )
                                        ->afterStateUpdated(function (Set $set, Get $get) {
                                            $set('barangay_id', null);
                                            static::updateFullAddress($set, $get);
                                        })
                                        ->visible(fn (Get $get): bool => filled($get('province_id'))),

                                    // Barangay Select
                                    Select::make('barangay_id')
                                        ->label('Barangay')
                                        ->required()
                                        ->searchable()
                                        ->optionsLimit(50)
                                        ->native(false)
                                        ->live()
                                        ->options(function (Get $get) {
                                            $cityId = $get('city_id');
                                            if (!$cityId) {
                                                return [];
                                            }

                                            return Cache::remember("barangays_for_city_{$cityId}", 1800, function () use ($cityId) {
                                                $city = PhilippineCity::find($cityId);
                                                if (!$city) {
                                                    return [];
                                                }

                                                return PhilippineBarangay::where('city_code', $city->code)
                                                    ->orderBy('name')
                                                    ->pluck('name', 'id')
                                                    ->toArray();
                                            });
                                        })
                                        ->getSearchResultsUsing(function (string $search, Get $get): array {
                                            $cityId = $get('city_id');
                                            if (!$cityId) {
                                                return [];
                                            }

                                            $city = PhilippineCity::find($cityId);
                                            if (!$city) {
                                                return [];
                                            }

                                            return PhilippineBarangay::where('city_code', $city->code)
                                                ->where('name', 'like', "%{$search}%")
                                                ->limit(50)
                                                ->pluck('name', 'id')
                                                ->toArray();
                                        })
                                        ->getOptionLabelUsing(fn ($value): ?string =>
                                            Cache::remember("barangay_label_{$value}", 1800, function () use ($value) {
                                                return PhilippineBarangay::find($value)?->name;
                                            })
                                        )
                                        ->afterStateUpdated(function (Set $set, Get $get) {
                                            static::updateFullAddress($set, $get);
                                        })
                                        ->visible(fn (Get $get): bool => filled($get('city_id'))),

                                    TextInput::make('street_address')
                                    ->label('Street Address')
                                    ->maxLength(255)
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Set $set, Get $get) {
                                        static::updateFullAddress($set, $get);
                                    })
                                    ->columnSpanFull(),

                                    TextInput::make('full_address')
                                        ->label('Full Address')
                                        ->required()
                                        ->maxLength(255)
                                        ->disabled()
                                        ->dehydrated()
                                        ->columnSpanFull()
                                        ->placeholder('Address will be generated automatically...'),
                                ])
                                ->columns([
                                    'sm' => 1,
                                    'md' => 2,
                                    'lg' => 2
                                ])
                            ]),
                        ]),
                    Tabs\Tab::make('Affiliation & Others')
                        ->icon('heroicon-m-user-group')
                        ->schema([
                            Section::make('Skills')
                            ->schema([
                                
                            ])
                        ]),
                ])
                ->contained(false)


            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('update')
                ->label('Update Profile')
                ->color('primary')
                ->action('update'),
        ];
    }

    public function update()
    {
        $data = $this->form->getState();
        $user = auth()->user();

        // Separate data for users table and profile table
        $userData = [
            'email' => $data['email'],
        ];

        // Handle password update
        if (!empty($data['password'])) {
            $userData['password'] = Hash::make($data['password']);
        }

        // Update name field by combining first_name and last_name
        $userData['name'] = $data['first_name'] . ' ' . $data['last_name'];

        // Update user table
        $user->update($userData);

        // Prepare profile data
        $profileData = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone' => $data['phone'],
            'emergency_contact' => $data['emergency_contact'],
            'emergency_contact_phone' => $data['emergency_contact_phone'],
            'region_id' => $data['region_id'],
            'province_id' => $data['province_id'],
            'city_id' => $data['city_id'],
            'barangay_id' => $data['barangay_id'],
            'street' => $data['street_address'],
            'full_address' => $data['full_address'],
        ];

        // Update or create profile
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $profileData
        );

        Notification::make()
            ->title('Profile updated successfully!')
            ->success()
            ->send();

        return redirect()->to(static::getUrl());
    }
}
