<?php

namespace App\Filament\Admin\Resources\IncidentResource\Widgets;

use App\Models\Incident;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class IncidentStatsTableOverview extends BaseWidget
{

    protected function getStats(): array
    {
        $oneWeekAgo = now()->subWeek();
        $sevenDaysAgo = now()->subDays(6)->startOfDay();

        // Get current counts and last week counts in a single query
        $priorityCounts = Incident::select('priority')
            ->selectRaw('COUNT(*) as current_count')
            ->selectRaw('SUM(CASE WHEN created_at < ? THEN 1 ELSE 0 END) as last_week_count', [$oneWeekAgo])
            ->whereIn('priority', ['critical', 'high', 'medium', 'low'])
            ->groupBy('priority')
            ->get()
            ->keyBy('priority');

        // Get trend data for last 7 days in a single query
        $trendData = Incident::select('priority')
            ->selectRaw('DATE(created_at) as date')
            ->selectRaw('COUNT(*) as count')
            ->where('created_at', '>=', $sevenDaysAgo)
            ->whereIn('priority', ['critical', 'high', 'medium'])
            ->groupBy('priority', 'date')
            ->orderBy('date')
            ->get()
            ->groupBy('priority');

        // Process trend data
        $trends = $this->processTrendData($trendData);

        // Build stats with cached data
        $stats = [];
        foreach (['critical' => 'danger', 'high' => 'danger', 'medium' => 'warning', 'low' => 'success'] as $priority => $color) {
            $current = $priorityCounts->get($priority)->current_count ?? 0;
            $lastWeek = $priorityCounts->get($priority)->last_week_count ?? 0;
            $change = $lastWeek > 0 ? round((($current - $lastWeek) / $lastWeek) * 100, 1) : 0;

            $stat = Stat::make(ucfirst($priority) . ' Priority', $current)
                ->color($color);

            if ($priority !== 'low') {
                $stat->description($this->getChangeDescription($change))
                    ->descriptionIcon($change >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                    ->chart($trends[$priority] ?? array_fill(0, 7, 0));
            } else {
                $stat->description('Total incidents')
                    ->descriptionIcon('heroicon-m-information-circle');
            }

            $stats[] = $stat;
        }

        return $stats;
    }

    protected function processTrendData($trendData): array
    {
        $trends = [];
        $priorities = ['critical', 'high', 'medium'];

        foreach ($priorities as $priority) {
            $data = array_fill(0, 7, 0);
            $priorityData = $trendData->get($priority, collect());

            foreach ($priorityData as $item) {
                $daysAgo = now()->startOfDay()->diffInDays($item->date, false);
                $index = 6 + $daysAgo;
                if ($index >= 0 && $index < 7) {
                    $data[$index] = $item->count;
                }
            }

            $trends[$priority] = $data;
        }

        return $trends;
    }

    protected function getChangeDescription(float $change): string
    {
        if ($change == 0) {
            return 'No change from last week';
        }

        $absChange = abs($change);
        $direction = $change > 0 ? 'increase' : 'decrease';

        return "{$absChange}% {$direction} from last week";
    }

    // protected function getStats(): array
    // {
    //     // Get current counts
    //     $criticalCount = Incident::where('priority', 'critical')->count();
    //     $highCount = Incident::where('priority', 'high')->count();
    //     $mediumCount = Incident::where('priority', 'medium')->count();
    //     $lowCount = Incident::where('priority', 'low')->count();

    //     // Get previous week counts for comparison
    //     $criticalLastWeek = Incident::where('priority', 'critical')
    //         ->where('created_at', '<', now()->subWeek())
    //         ->count();
    //     $highLastWeek = Incident::where('priority', 'high')
    //         ->where('created_at', '<', now()->subWeek())
    //         ->count();
    //     $mediumLastWeek = Incident::where('priority', 'medium')
    //         ->where('created_at', '<', now()->subWeek())
    //         ->count();

    //     // Calculate percentage changes
    //     $criticalChange = $criticalLastWeek > 0
    //         ? round((($criticalCount - $criticalLastWeek) / $criticalLastWeek) * 100, 1)
    //         : 0;
    //     $highChange = $highLastWeek > 0
    //         ? round((($highCount - $highLastWeek) / $highLastWeek) * 100, 1)
    //         : 0;
    //     $mediumChange = $mediumLastWeek > 0
    //         ? round((($mediumCount - $mediumLastWeek) / $mediumLastWeek) * 100, 1)
    //         : 0;

    //     // Get trend data for last 7 days
    //     $criticalTrend = $this->getPriorityTrend('critical');
    //     $highTrend = $this->getPriorityTrend('high');
    //     $mediumTrend = $this->getPriorityTrend('medium');

    //     return [
    //         Stat::make('Critical Priority', $criticalCount)
    //             ->description($this->getChangeDescription($criticalChange))
    //             ->descriptionIcon($criticalChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
    //             ->chart($criticalTrend)
    //             ->color('danger'),

    //         Stat::make('High Priority', $highCount)
    //             ->description($this->getChangeDescription($highChange))
    //             ->descriptionIcon($highChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
    //             ->chart($highTrend)
    //             ->color('danger'),

    //         Stat::make('Medium Priority', $mediumCount)
    //             ->description($this->getChangeDescription($mediumChange))
    //             ->descriptionIcon($mediumChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
    //             ->chart($mediumTrend)
    //             ->color('warning'),

    //         Stat::make('Low Priority', $lowCount)
    //             ->description('Total incidents')
    //             ->descriptionIcon('heroicon-m-information-circle')
    //             ->color('success'),
    //     ];
    // }

    // protected function getPriorityTrend(string $priority): array
    // {
    //     $data = [];

    //     for ($i = 6; $i >= 0; $i--) {
    //         $date = now()->subDays($i)->startOfDay();
    //         $count = Incident::where('priority', $priority)
    //             ->whereDate('created_at', $date)
    //             ->count();
    //         $data[] = $count;
    //     }

    //     return $data;
    // }

    // protected function getChangeDescription(float $change): string
    // {
    //     if ($change == 0) {
    //         return 'No change from last week';
    //     }

    //     $absChange = abs($change);
    //     $direction = $change > 0 ? 'increase' : 'decrease';

    //     return "{$absChange}% {$direction} from last week";
    // }
}
