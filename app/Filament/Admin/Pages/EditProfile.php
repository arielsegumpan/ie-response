<?php

namespace App\Filament\Admin\Pages;

<<<<<<< HEAD
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Concerns\InteractsWithForms;

class EditProfile extends Page implements HasForms
{
    use InteractsWithForms;

    // protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.admin.pages.edit-profile';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            // 'first_name' => auth()->user()->profile?->first_name,
            // 'last_name' => auth()->user()->profile?->last_name,
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
                Section::make()
                ->schema([
                    Fieldset::make('Account details')
                    ->schema([
                        TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                        TextInput::make('email')
                        ->email()
                        ->required()
                        ->maxLength(255),

                        TextInput::make('password')
                        ->password()
                        ->revealable()
                        ->minLength(8)
                        ->maxLength(255),

                        TextInput::make('password_confirmation')
                        ->password()
                        ->revealable()
                        ->minLength(8)
                        ->maxLength(255),
                    ]),

                ])
                ->columns([
                    'sm' => 1,
                    'md' => 2,
                    'lg' => 2
                ])

            ])
            ->statePath('data')
            ->model(auth()->user());
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

        // Remove password from data if it's empty
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            // Hash the password if provided
            $data['password'] = Hash::make($data['password']);
        }

        // Remove password_confirmation as it's not needed in the database
        unset($data['password_confirmation']);

        auth()->user()->update($data);

        Notification::make()
            ->title('Profile updated successfully!')
            ->success()
            ->send();

        return redirect()->to(static::getUrl());
    }
=======
use Filament\Pages\Page;

class EditProfile extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.admin.pages.edit-profile';
>>>>>>> c2aafa8681cabc998adb21c22e39ae68f307e8b2
}
