<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum AvailabilityStatusEnum: string implements HasIcon, HasColor, HasLabel
{
    case AVAILABLE = 'available';
    case BUSY = 'busy';
    case UNAVAILABLE = 'unavailable';


    public function getIcon(): ?string
    {
        return match ($this) {
            self::AVAILABLE => 'heroicon-o-check-circle',
            self::BUSY => 'heroicon-o-arrow-path',
            self::UNAVAILABLE => 'heroicon-o-x-circle',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::AVAILABLE => 'success',
            self::BUSY => 'warning',
            self::UNAVAILABLE => 'danger',
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::AVAILABLE => 'Available',
            self::BUSY => 'Busy',
            self::UNAVAILABLE => 'Unavailable',
        };
    }
}
