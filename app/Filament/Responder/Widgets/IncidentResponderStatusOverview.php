<?php

namespace App\Filament\Responder\Widgets;

use App\Models\Incident;
use App\Models\Volunteer;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class IncidentResponderStatusOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $incidentStats = Incident::selectRaw('
                COUNT(*) as total,
                SUM(CASE WHEN status IN ("reported", "verified", "in_progress") THEN 1 ELSE 0 END) as active,
                SUM(CASE WHEN status = "resolved" THEN 1 ELSE 0 END) as resolved,
                SUM(CASE WHEN priority = "critical" AND status IN ("reported", "verified", "in_progress") THEN 1 ELSE 0 END) as critical
            ')
            ->first();

        $volunteerStats = Volunteer::selectRaw('
                SUM(CASE WHEN availability_status = "available" AND verification_status = "verified" AND is_active = 1 THEN 1 ELSE 0 END) as available,
                SUM(CASE WHEN verification_status = "pending" THEN 1 ELSE 0 END) as pending
            ')
            ->first();

        return [
            Stat::make('Total Incidents', $incidentStats->total ?? 0)
                ->description('All time incidents')
                ->descriptionIcon('heroicon-o-fire')
                ->color('primary')
                ->chart($this->getIncidentTrend()),

            Stat::make('Active Incidents', $incidentStats->active ?? 0)
                ->description('Currently active')
                ->descriptionIcon('heroicon-o-exclamation-triangle')
                ->color('warning'),

            Stat::make('Critical Incidents', $incidentStats->critical ?? 0)
                ->description('Requires immediate attention')
                ->descriptionIcon('heroicon-o-bell-alert')
                ->color('danger'),

            Stat::make('Available Volunteers', $volunteerStats->available ?? 0)
                ->description(($volunteerStats->pending ?? 0) . " pending verification")
                ->descriptionIcon('heroicon-o-user-group')
                ->color('success'),
        ];
    }

    protected function getIncidentTrend(): array
    {
        $trends = Incident::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        $trendArray = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $trendArray[] = $trends->get($date, 0);
        }

        return $trendArray;
    }
}
