@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <h1 class="h3 mb-4">Dashboard</h1>

    <div class="row g-3 mb-4">
        <div class="col-sm-4">
            <div class="card card-salon h-100"><div class="card-body">
                <div class="small text-secondary">Menunggu konfirmasi</div>
                <div class="display-6">{{ $pendingCount }}</div>
            </div></div>
        </div>
        <div class="col-sm-4">
            <div class="card card-salon h-100"><div class="card-body">
                <div class="small text-secondary">Booking hari ini</div>
                <div class="display-6">{{ $todayCount }}</div>
            </div></div>
        </div>
        <div class="col-sm-4">
            <div class="card card-salon h-100"><div class="card-body">
                <div class="small text-secondary">Layanan aktif</div>
                <div class="display-6">{{ $serviceCount }}</div>
            </div></div>
        </div>
    </div>

    <div class="card card-salon">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="h5 mb-0">Perlu dikonfirmasi</h2>
                <a href="{{ route('admin.bookings.index', ['status' => 'menunggu']) }}" class="small">Lihat semua</a>
            </div>

            @forelse ($pending as $booking)
                <div class="d-flex justify-content-between border-top py-2">
                    <div>
                        <strong>{{ $booking->customer_name }}</strong>
                        <div class="small text-secondary">{{ $booking->service->name }}</div>
                    </div>
                    <div class="text-end small">
                        {{ $booking->booking_date->translatedFormat('D, j M') }}<br>{{ $booking->timeLabel() }}
                    </div>
                </div>
            @empty
                <p class="text-secondary mb-0">Tidak ada booking yang menunggu.</p>
            @endforelse
        </div>
    </div>
@endsection
