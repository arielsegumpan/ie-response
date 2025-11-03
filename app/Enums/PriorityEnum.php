<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum PriorityEnum: string implements HasIcon, HasColor, HasLabel
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';
    case CRITICAL = 'critical';


    public function getIcon(): ?string
    {
        return match ($this) {
            self::LOW => 'heroicon-o-arrow-trending-down',
            self::MEDIUM => 'heroicon-o-arrows-right-left',
            self::HIGH => 'heroicon-o-arrow-trending-up',
            self::CRITICAL => 'heroicon-o-exclamation-triangle',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::LOW => 'success',
            self::MEDIUM => 'warning',
            self::HIGH => 'danger',
            self::CRITICAL => 'danger',
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::LOW => 'Low',
            self::MEDIUM => 'Medium',
            self::HIGH => 'High',
            self::CRITICAL => 'Critical',
        };
    }
}
