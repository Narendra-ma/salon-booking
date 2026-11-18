@extends('layouts.admin')

@section('title', 'Booking')

@section('content')
    <h1 class="h3 mb-3">Booking</h1>

    <form method="GET" class="row g-2 align-items-end mb-3">
        <div class="col-sm-4 col-md-3">
            <label for="status" class="form-label small mb-1">Status</label>
            <select id="status" name="status" class="form-select">
                <option value="">Semua</option>
                @foreach ($statuses as $status)
                    <option value="{{ $status->value }}" @selected(request('status') === $status->value)>{{ $status->label() }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-4 col-md-3">
            <label for="tanggal" class="form-label small mb-1">Tanggal</label>
            <input type="date" id="tanggal" name="tanggal" value="{{ request('tanggal') }}" class="form-control">
        </div>
        <div class="col-sm-4 col-md-3">
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="riwayat" name="riwayat" value="1" @checked(request()->boolean('riwayat'))>
                <label class="form-check-label small" for="riwayat">Termasuk yang sudah lewat</label>
            </div>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button class="btn btn-salon">Terapkan</button>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary rounded-pill">Reset</a>
        </div>
    </form>

    <div class="card card-salon">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Jadwal</th>
                        <th>Pelanggan</th>
                        <th>Layanan</th>
                        <th>Pegawai</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bookings as $booking)
                        <tr>
                            <td class="text-nowrap">
                                {{ $booking->booking_date->translatedFormat('D, j M Y') }}<br>
                                <span class="small text-secondary">{{ $booking->timeLabel() }}</span>
                            </td>
                            <td>
                                {{ $booking->customer_name }}<br>
                                <span class="small text-secondary">+{{ $booking->customer_phone }}</span>
                            </td>
                            <td>{{ $booking->service->name }}</td>
                            <td>{{ $booking->employee?->name ?? '-' }}</td>
                            <td><span class="badge {{ $booking->status->badge() }}">{{ $booking->status->label() }}</span></td>
                            <td class="text-end text-nowrap">
                                @can('approve', $booking)
                                    <form method="POST" action="{{ route('admin.bookings.approve', $booking) }}" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-sm btn-success">Setujui</button>
                                    </form>
                                @endcan

                                @if ($booking->status === \App\Enums\BookingStatus::Disetujui)
                                    <a href="{{ $booking->whatsappUrl() }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-whatsapp"></i> Kirim WA
                                    </a>
                                @endif

                                @can('cancel', $booking)
                                    <form method="POST" action="{{ route('admin.bookings.cancel', $booking) }}" class="d-inline"
                                          onsubmit="return confirm('Batalkan booking {{ e($booking->customer_name) }}?')">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-sm btn-outline-danger">Batalkan</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-secondary py-4">Tidak ada booking.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $bookings->links() }}</div>
@endsection
