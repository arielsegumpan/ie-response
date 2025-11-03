<?php

namespace App\Filament\Responder\Widgets;

use App\Models\Incident;
use Filament\Widgets\ChartWidget;

class IncidentResponderPriorityChart extends ChartWidget
{
    protected static ?string $heading = 'Incidents by Priority';
    protected static ?int $sort = 4;
    protected static ?string $maxHeight = '250px';

    protected function getData(): array
    {
        $priorities = ['low', 'medium', 'high', 'critical'];
        $activeData = [];
        $resolvedData = [];

        foreach ($priorities as $priority) {
            $activeData[] = Incident::where('priority', $priority)
                ->whereIn('status', ['reported', 'verified', 'in_progress'])
                ->count();

            $resolvedData[] = Incident::where('priority', $priority)
                ->where('status', 'resolved')
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Active',
                    'data' => $activeData,
                    'backgroundColor' => '#ef4444',
                    'borderRadius' => 150,
                    'borderWidth' => 0,
                    'maxBarThickness' => 30
                ],
                [
                    'label' => 'Resolved',
                    'data' => $resolvedData,
                    'backgroundColor' => '#10b981',
                    'borderRadius' => 150,
                    'borderWidth' => 0,
                    'maxBarThickness' => 30
                ],
            ],
            'labels' => ['Low', 'Medium', 'High', 'Critical'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
