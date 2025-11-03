<?php

namespace App\Filament\Admin\Resources\VolunteerResource\Widgets;

use App\Models\Volunteer;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class ResponderTableOverview extends BaseWidget
{
   protected function getStats(): array
    {
        // Get all verification status counts in a single optimized query
        $statusCounts = Volunteer::select('verification_status')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('verification_status')
            ->get()
            ->keyBy('verification_status');

        // Get counts with default to 0 if status doesn't exist
        $pendingCount = $statusCounts->get('pending')->count ?? 0;
        $verifiedCount = $statusCounts->get('verified')->count ?? 0;
        $rejectedCount = $statusCounts->get('rejected')->count ?? 0;

        // Calculate total for percentage context
        $total = $pendingCount + $verifiedCount + $rejectedCount;

        return [
            Stat::make('Pending Verification', $pendingCount)
                ->description($total > 0 ? round(($pendingCount / $total) * 100, 1) . '% of total volunteers' : 'No volunteers yet')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Verified Volunteers', $verifiedCount)
                ->description($total > 0 ? round(($verifiedCount / $total) * 100, 1) . '% of total volunteers' : 'No volunteers yet')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            Stat::make('Rejected Applications', $rejectedCount)
                ->description($total > 0 ? round(($rejectedCount / $total) * 100, 1) . '% of total volunteers' : 'No volunteers yet')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
        ];
    }
}
