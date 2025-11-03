<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Incident;
use App\Models\Volunteer;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalIncidents = Incident::count();
        $activeIncidents = Incident::whereIn('status', ['reported', 'verified', 'in_progress'])->count();
        $resolvedIncidents = Incident::where('status', 'resolved')->count();
        $criticalIncidents = Incident::where('priority', 'critical')->whereIn('status', ['reported', 'verified', 'in_progress'])->count();

        $availableVolunteers = Volunteer::where('availability_status', 'available')
            ->where('verification_status', 'verified')
            ->where('is_active', true)
            ->count();

        $pendingVerification = Volunteer::where('verification_status', 'pending')->count();

        return [

            Stat::make('Total Incidents', $totalIncidents)
                ->description('All time incidents')
                ->descriptionIcon('heroicon-o-fire')
                ->color('primary')
                ->chart($this->getIncidentTrend()),

            Stat::make('Active Incidents', $activeIncidents)
                ->description('Currently active')
                ->descriptionIcon('heroicon-o-exclamation-triangle')
                ->color('warning'),

            Stat::make('Critical Incidents', $criticalIncidents)
                ->description('Requires immediate attention')
                ->descriptionIcon('heroicon-o-bell-alert')
                ->color('danger'),

            Stat::make('Available Volunteers', $availableVolunteers)
                ->description("{$pendingVerification} pending verification")
                ->descriptionIcon('heroicon-o-user-group')
                ->color('success'),
                
        ];


    }

    protected function getIncidentTrend(): array
    {
        return Incident::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count')
            ->toArray();
    }
}
