<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'duration_minutes', 'price', 'is_active'];

    protected function casts(): array
    {
        return [
            'duration_minutes' => 'integer',
            'price' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    public function priceLabel(): string
    {
        return 'Rp '.number_format($this->price, 0, ',', '.');
    }

    public function durationLabel(): string
    {
        $jam = intdiv($this->duration_minutes, 60);
        $menit = $this->duration_minutes % 60;

        return trim(($jam ? "$jam jam " : '').($menit ? "$menit menit" : ''));
    }
}
