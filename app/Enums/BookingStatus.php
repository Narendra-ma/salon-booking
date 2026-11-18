<?php

namespace App\Enums;

enum BookingStatus: string
{
    case Menunggu = 'menunggu';
    case Disetujui = 'disetujui';
    case Dibatalkan = 'dibatalkan';

    public function label(): string
    {
        return ucfirst($this->value);
    }

    public function badge(): string
    {
        return match ($this) {
            self::Menunggu => 'text-bg-warning',
            self::Disetujui => 'text-bg-success',
            self::Dibatalkan => 'text-bg-secondary',
        };
    }
}
