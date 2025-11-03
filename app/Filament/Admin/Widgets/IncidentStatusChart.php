<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Incident;
use Filament\Widgets\ChartWidget;

class IncidentStatusChart extends ChartWidget
{
    protected static ?string $heading = 'Incidents by Status';
    protected static ?int $sort = 2;
    protected static ?string $maxHeight = '250px';

    protected function getData(): array
    {
         $statuses = ['reported', 'verified', 'in_progress', 'resolved', 'closed'];
        $data = [];

        foreach ($statuses as $status) {
            $data[] = Incident::where('status', $status)->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Incidents',
                    'data' => $data,
                    'backgroundColor' => [
                        '#3b82f6', // blue
                        '#f59e0b', // amber
                        '#8b5cf6', // violet
                        '#10b981', // green
                        '#6b7280', // gray
                    ],
                    'spacing' => 10
                ],
            ],
            'labels' => ['Reported', 'Verified', 'In Progress', 'Resolved', 'Closed'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
