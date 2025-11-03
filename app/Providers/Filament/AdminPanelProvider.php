<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
<<<<<<< HEAD
use Filament\Navigation\MenuItem;
use Filament\Support\Colors\Color;
=======
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\URL;
>>>>>>> c2aafa8681cabc998adb21c22e39ae68f307e8b2
use Filament\Pages\Auth\EditProfile;
use Filament\Navigation\NavigationGroup;
use Filament\Http\Middleware\Authenticate;
use App\Http\Middleware\PanelRoleMiddleware;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Filament\Http\Middleware\AuthenticateSession;
<<<<<<< HEAD
use App\Filament\Admin\Pages\EditProfile as EditProf;
=======
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
>>>>>>> c2aafa8681cabc998adb21c22e39ae68f307e8b2
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
<<<<<<< HEAD
=======
        URL::forceScheme('https');
>>>>>>> c2aafa8681cabc998adb21c22e39ae68f307e8b2
        return $panel
            ->id('admin')
            ->path('admin')
            ->spa()
<<<<<<< HEAD
=======
            ->profile(EditProfile::class)
>>>>>>> c2aafa8681cabc998adb21c22e39ae68f307e8b2
            ->font('Poppins')
            ->brandLogo(asset('imgs/ie-logo.png'))
            ->brandLogoHeight('3rem')
            ->favicon(asset('imgs/ie-logo.png'))
            // ->sidebarCollapsibleOnDesktop()
            ->registration()
            ->sidebarWidth('17rem')
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\\Filament\\Admin\\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\\Filament\\Admin\\Pages')
<<<<<<< HEAD
=======
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\\Filament\\Admin\\Widgets')
>>>>>>> c2aafa8681cabc998adb21c22e39ae68f307e8b2
            ->navigationGroups([

                NavigationGroup::make()
                ->label('Posts')
                ->icon('heroicon-o-document-text'),

                NavigationGroup::make()
                ->label('Settings')
                ->icon('heroicon-o-cog-6-tooth'),

                NavigationGroup::make()
                ->label('Users & Roles')
            ])
<<<<<<< HEAD
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\\Filament\\Admin\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
=======
            ->widgets([
                Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
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
                PanelRoleMiddleware::class
            ])
<<<<<<< HEAD
            ->databaseNotifications()
            ->userMenuItems([
                MenuItem::make()
                    ->label('My Profile')
                    ->url(fn (): string => EditProf::getUrl())
                    ->icon('heroicon-o-user-circle'),
            ])
            ->plugins([
                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make(),
=======
            ->sidebarWidth('17rem')
            ->plugins([
                FilamentShieldPlugin::make()
>>>>>>> c2aafa8681cabc998adb21c22e39ae68f307e8b2
            ]);
    }
}
