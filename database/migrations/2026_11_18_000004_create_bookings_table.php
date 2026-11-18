<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            // Layanan tidak boleh terhapus kalau sudah punya booking
            $table->foreignId('service_id')->constrained()->restrictOnDelete();
            // Diisi otomatis saat booking; null kalau pegawainya dihapus
            $table->foreignId('employee_id')->nullable()->constrained()->nullOnDelete();
            $table->string('customer_name', 100);
            $table->string('customer_phone', 20);
            $table->date('booking_date');
            $table->time('start_time');
            // Disimpan supaya cek bentrok tinggal bandingkan kolom, dan tidak
            // berubah walau durasi layanan diedit belakangan
            $table->time('end_time');
            $table->string('status', 20)->default('menunggu');
            $table->timestamps();

            // Melayani cek bentrok (tanggal sama + rentang jam) dan urutan daftar di admin
            $table->index(['booking_date', 'start_time']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
