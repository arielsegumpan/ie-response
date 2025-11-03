<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Volunteer;
use Filament\Widgets\ChartWidget;

class VolunteerStatusChart extends ChartWidget
{
    protected static ?string $heading = 'Volunteer Availability';
    protected static ?int $sort = 3;
    protected static ?string $maxHeight = '250px';

    protected function getData(): array
    {
        // Get all availability status counts for verified volunteers in a single query
        $statusCounts = Volunteer::select('availability_status')
            ->selectRaw('COUNT(*) as count')
            ->where('verification_status', 'verified')
            ->groupBy('availability_status')
            ->get()
            ->keyBy('availability_status');

        // Extract counts with default to 0 if status doesn't exist
        $available = $statusCounts->get('available')->count ?? 0;
        $busy = $statusCounts->get('busy')->count ?? 0;
        $unavailable = $statusCounts->get('unavailable')->count ?? 0;

        return [
            'datasets' => [
                [
                    'label' => 'Volunteers',
                    'data' => [$available, $busy, $unavailable],
                    'backgroundColor' => [
                        '#10b981',
                        '#f59e0b',
                        '#ef4444',
                    ],
                    'spacing' => 10
                ],
            ],
            'labels' => ['Available', 'Busy', 'Unavailable'],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
