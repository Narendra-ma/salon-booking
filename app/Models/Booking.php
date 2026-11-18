<?php

namespace App\Models;

use App\Enums\BookingStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id', 'employee_id', 'customer_name', 'customer_phone',
        'booking_date', 'start_time', 'end_time', 'status',
    ];

    protected function casts(): array
    {
        return [
            // Format eksplisit supaya tersimpan sebagai Y-m-d dan cocok dibandingkan di SQLite maupun MySQL
            'booking_date' => 'date:Y-m-d',
            'status' => BookingStatus::class,
        ];
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    // Booking yang dibatalkan tidak lagi memblokir jadwal
    public function scopeActive(Builder $query): void
    {
        $query->where('status', '!=', BookingStatus::Dibatalkan);
    }

    // Dua rentang waktu bentrok kalau masing-masing mulai sebelum yang lain selesai.
    // Selesai tepat saat yang lain mulai (10:00-11:00 lalu 11:00-12:00) tidak bentrok.
    public function scopeOverlapping(Builder $query, string $date, string $start, string $end): void
    {
        $query->where('booking_date', $date)
            ->where('start_time', '<', $end)
            ->where('end_time', '>', $start);
    }

    public function timeLabel(): string
    {
        return substr($this->start_time, 0, 5).' - '.substr($this->end_time, 0, 5);
    }

    // wa.me butuh nomor internasional tanpa "+" (sudah disimpan dalam format 62...)
    // dan teks pesan yang di-URL-encode. rawurlencode memakai %20 untuk spasi dan %0A
    // untuk baris baru, yang dimengerti WhatsApp.
    public function whatsappUrl(): string
    {
        $pesan = sprintf(
            "Halo Kak %s, booking Kakak di %s sudah kami konfirmasi.\n\n"
            ."Layanan: %s\nHari/tanggal: %s\nJam: %s WIB\n\n"
            .'Kami tunggu kedatangannya ya, Kak. Kalau mau ubah jadwal, balas pesan ini.',
            $this->customer_name,
            config('salon.name'),
            $this->service->name,
            $this->booking_date->translatedFormat('l, j F Y'),
            substr($this->start_time, 0, 5),
        );

        return 'https://wa.me/'.$this->customer_phone.'?text='.rawurlencode($pesan);
    }
}
