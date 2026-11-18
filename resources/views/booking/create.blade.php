@extends('layouts.app')

@section('title', 'Booking')

@section('content')
    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-xl-6">
                    <div class="text-center mb-4">
                        <p class="eyebrow mb-2">Booking Online</p>
                        <h1 class="h2">Pilih Jadwal Anda</h1>
                    </div>

                    @if (session('booking_summary'))
                        @php($summary = session('booking_summary'))
                        <div class="card card-salon">
                            <div class="card-body p-4 text-center">
                                <span class="icon-circle mb-3"><i class="bi bi-check2-circle"></i></span>
                                <h2 class="h4">Terima kasih, {{ $summary['name'] }}!</h2>
                                <p>Booking Anda sudah kami terima dan <strong>menunggu konfirmasi</strong>. Kami akan menghubungi Anda lewat WhatsApp.</p>
                                <ul class="list-unstyled mb-4">
                                    <li><strong>Layanan:</strong> {{ $summary['service'] }}</li>
                                    <li><strong>Tanggal:</strong> {{ $summary['date'] }}</li>
                                    <li><strong>Jam:</strong> {{ $summary['time'] }} WIB</li>
                                </ul>
                                <a href="{{ route('home') }}" class="btn btn-salon-outline">Kembali ke Beranda</a>
                            </div>
                        </div>
                    @else
                        <div class="card card-salon">
                            <div class="card-body p-4">
                                <form method="POST" action="{{ route('booking.store') }}" novalidate>
                                    @csrf

                                    <div class="mb-3">
                                        <label for="customer_name" class="form-label">Nama</label>
                                        <input type="text" id="customer_name" name="customer_name"
                                               class="form-control @error('customer_name') is-invalid @enderror"
                                               value="{{ old('customer_name') }}" maxlength="100" required autocomplete="name">
                                        @error('customer_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="customer_phone" class="form-label">Nomor WhatsApp</label>
                                        <input type="tel" id="customer_phone" name="customer_phone"
                                               class="form-control @error('customer_phone') is-invalid @enderror"
                                               value="{{ old('customer_phone') }}" placeholder="0812-3456-7890" required autocomplete="tel">
                                        @error('customer_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="service_id" class="form-label">Layanan</label>
                                        <select id="service_id" name="service_id"
                                                class="form-select @error('service_id') is-invalid @enderror" required>
                                            <option value="">Pilih layanan</option>
                                            @foreach ($services as $service)
                                                <option value="{{ $service->id }}" @selected(old('service_id', $selectedService) == $service->id)>
                                                    {{ $service->name }} - {{ $service->durationLabel() }} - {{ $service->priceLabel() }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('service_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6 mb-3">
                                            <label for="booking_date" class="form-label">Tanggal</label>
                                            <input type="date" id="booking_date" name="booking_date"
                                                   class="form-control @error('booking_date') is-invalid @enderror"
                                                   value="{{ old('booking_date') }}" min="{{ $minDate }}" max="{{ $maxDate }}" required>
                                            @error('booking_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <label for="start_time" class="form-label">Jam</label>
                                            <select id="start_time" name="start_time"
                                                    class="form-select @error('start_time') is-invalid @enderror" required>
                                                <option value="">Pilih jam</option>
                                                @foreach ($slots as $slot)
                                                    <option value="{{ $slot }}" @selected(old('start_time') === $slot)>{{ $slot }} WIB</option>
                                                @endforeach
                                            </select>
                                            @error('start_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-salon btn-lg">Kirim Booking</button>
                                    </div>
                                    <p class="small text-secondary text-center mt-3 mb-0">
                                        Booking baru berstatus <em>menunggu</em> sampai kami konfirmasi lewat WhatsApp.
                                    </p>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
