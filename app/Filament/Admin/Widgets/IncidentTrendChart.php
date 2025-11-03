<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Incident;
use Filament\Widgets\ChartWidget;

class IncidentTrendChart extends ChartWidget
{
    protected static ?string $heading = 'Incident Trends (Last 30 Days)';
    protected static ?int $sort = 5;
    protected static ?string $maxHeight = '250px';

    protected function getData(): array
    {
        $data = Incident::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $dates = [];
        $counts = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dates[] = now()->subDays($i)->format('M d');

            $record = $data->firstWhere('date', $date);
            $counts[] = $record ? $record->count : 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Incidents Reported',
                    'data' => $counts,
                    'borderColor' => 'oklch(63.7% 0.237 25.331)',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'fill' => true,
                    'tension' => 0.3
                ],
            ],
            'labels' => $dates,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
