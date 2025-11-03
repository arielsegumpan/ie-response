<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum IncidentStatusEnum: string implements HasIcon, HasColor, HasLabel
{
    case REPORTED = 'reported';
    case VERIFIED = 'verified';
    case IN_PROGRESS = 'in_progress';
    case RESOLVED = 'resolved';
    case CLOSED = 'closed';

    public function getIcon(): ?string
    {
        return match ($this) {
            self::REPORTED => 'heroicon-o-flag',
            self::VERIFIED => 'heroicon-o-check-circle',
            self::IN_PROGRESS => 'heroicon-o-arrow-path',
            self::RESOLVED => 'heroicon-o-check-circle',
            self::CLOSED => 'heroicon-o-x-circle',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::REPORTED => 'warning',
            self::VERIFIED => 'success',
            self::IN_PROGRESS => 'warning',
            self::RESOLVED => 'success',
            self::CLOSED => 'danger',
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::REPORTED => 'Reported',
            self::VERIFIED => 'Verified',
            self::IN_PROGRESS => 'In Progress',
            self::RESOLVED => 'Resolved',
            self::CLOSED => 'Closed',
        };
    }
}
