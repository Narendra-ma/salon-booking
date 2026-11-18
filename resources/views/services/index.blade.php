@extends('layouts.app')

@section('title', 'Layanan & Harga')

@section('content')
    <section class="section">
        <div class="container">
            <div class="text-center mb-5">
                <p class="eyebrow mb-2">Layanan &amp; Harga</p>
                <h1 class="h2">Pilih Perawatan Anda</h1>
                <p class="mb-0">Harga dapat berubah sewaktu-waktu, tanyakan kami untuk paket atau promo terbaru.</p>
            </div>

            @if ($services->isEmpty())
                <p class="text-center text-secondary">Daftar layanan belum tersedia.</p>
            @else
                <div class="row g-4">
                    @foreach ($services as $service)
                        <div class="col-md-6 col-lg-4">
                            @include('services._card', ['service' => $service])
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
