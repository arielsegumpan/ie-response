<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Navigation\MenuItem;
use Filament\Support\Colors\Color;
use Filament\Http\Middleware\Authenticate;
use App\Filament\Responder\Pages\EditProfile as EditProf;
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

class ResponderPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('responder')
            ->path('responder')
            ->spa()
            ->font('Poppins')
            ->brandLogo(asset('imgs/ie-logo.png'))
            ->brandLogoHeight('3rem')
            ->favicon(asset('imgs/ie-logo.png'))
            ->sidebarWidth('17rem')
            ->discoverResources(in: app_path('Filament/Responder/Resources'), for: 'App\\Filament\\Responder\\Resources')
            ->discoverPages(in: app_path('Filament/Responder/Pages'), for: 'App\\Filament\\Responder\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Responder/Widgets'), for: 'App\\Filament\\Responder\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
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
                PanelRoleMiddleware::class
            ])
            ->databaseNotifications()
            ->userMenuItems([
                MenuItem::make()
                    ->label('My Profile')
                    ->url(fn (): string => EditProf::getUrl())
                    ->icon('heroicon-o-user-circle'),
            ])
            ->plugins([
                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make(),
            ]);
    }
}
