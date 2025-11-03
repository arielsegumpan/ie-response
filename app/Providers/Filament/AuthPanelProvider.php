<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
<<<<<<< HEAD
use App\Filament\Auth\Pages\Register;
=======
use Illuminate\Support\Facades\URL;
>>>>>>> c2aafa8681cabc998adb21c22e39ae68f307e8b2
use Filament\Http\Middleware\Authenticate;
use App\Http\Middleware\PanelRoleMiddleware;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Filament\Http\Middleware\AuthenticateSession;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class AuthPanelProvider extends PanelProvider
{

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('auth')
            ->path('auth')
            ->login()
            ->registration()
<<<<<<< HEAD
            ->font('Poppins')
=======
>>>>>>> c2aafa8681cabc998adb21c22e39ae68f307e8b2
            ->brandLogo(asset('imgs/ie-logo.png'))
            ->brandLogoHeight('5rem')
            ->favicon(asset('imgs/ie-logo.png'))
<<<<<<< HEAD
            ->registration(Register::class)
=======
>>>>>>> c2aafa8681cabc998adb21c22e39ae68f307e8b2
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
<<<<<<< HEAD
=======
                Widgets\FilamentInfoWidget::class,
>>>>>>> c2aafa8681cabc998adb21c22e39ae68f307e8b2
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
                PanelRoleMiddleware::class,
            ]);
    }
}
