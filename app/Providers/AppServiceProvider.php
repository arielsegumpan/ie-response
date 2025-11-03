<?php

namespace App\Providers;

use App\Models\Incident;
use App\Models\Volunteer;
use App\Observers\IncidentObserver;
use App\Observers\ResponderObserver;
use App\Http\Responses\LogoutResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentColor;
use App\Http\Responses\LoginResponse as LogRes;
use Filament\Http\Responses\Auth\LoginResponse;
use Filament\Http\Responses\Auth\Contracts\LogoutResponse as LogoutResponseContract;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Session::flush();
        $this->app->singleton(
            LoginResponse::class,
            LogRes::class
        );
        Session::flush();
        $this->app->bind(LogoutResponseContract::class, LogoutResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::automaticallyEagerLoadRelationships();
        FilamentColor::register([
            'primary' => [
                50 => '252, 242, 242',
                100 => '250, 229, 229',
                200 => '246, 203, 203',
                300 => '241, 167, 167',
                400 => '232, 123, 123',
                500 => '196, 22, 28',
                600 => '165, 17, 22',
                700 => '139, 14, 19',
                800 => '110, 12, 16',
                900 => '88, 9, 12',
                950 => '53, 6, 8',
            ],
        ]);
        Incident::observe(IncidentObserver::class);
        Volunteer::observe(ResponderObserver::class);
    }
}
