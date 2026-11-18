<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('salon.tagline')) | {{ config('salon.name') }}</title>
    <meta name="description" content="@yield('description', config('salon.name').' - '.config('salon.tagline').'. Booking online mudah, langsung konfirmasi lewat WhatsApp.')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/salon.css') }}" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-salon sticky-top">
        <div class="container">
            <a class="navbar-brand fs-4" href="{{ route('home') }}">{{ config('salon.name') }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu"
                    aria-controls="menu" aria-expanded="false" aria-label="Buka menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                    <li class="nav-item">
                        <a class="nav-link @if (request()->routeIs('home')) active @endif" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if (request()->routeIs('services.index')) active @endif" href="{{ route('services.index') }}">Layanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if (request()->routeIs('gallery')) active @endif" href="{{ route('gallery') }}">Galeri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if (request()->routeIs('contact')) active @endif" href="{{ route('contact') }}">Kontak</a>
                    </li>
                    <li class="nav-item mt-2 mt-lg-0">
                        <a class="btn btn-salon btn-sm" href="{{ route('booking.create') }}">Booking Sekarang</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="flex-grow-1">
        @yield('content')
    </main>

    <footer class="site-footer mt-5 pt-5 pb-4">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-5">
                    <h5 class="font-display">{{ config('salon.name') }}</h5>
                    <p class="mb-0">{{ config('salon.tagline') }}</p>
                </div>
                <div class="col-md-4">
                    <h5 class="font-display">Kunjungi Kami</h5>
                    <p class="mb-1"><i class="bi bi-geo-alt me-2"></i>{{ config('salon.address') }}</p>
                    <p class="mb-0"><i class="bi bi-clock me-2"></i>{{ config('salon.open_text') }}</p>
                </div>
                <div class="col-md-3">
                    <h5 class="font-display">Hubungi Kami</h5>
                    <p class="mb-1">
                        <a class="text-decoration-none" href="https://wa.me/{{ config('salon.whatsapp') }}" target="_blank" rel="noopener">
                            <i class="bi bi-whatsapp me-2"></i>WhatsApp
                        </a>
                    </p>
                    @if (config('salon.instagram'))
                        <p class="mb-0">
                            <a class="text-decoration-none" href="https://instagram.com/{{ config('salon.instagram') }}" target="_blank" rel="noopener">
                                <i class="bi bi-instagram me-2"></i>{{ '@'.config('salon.instagram') }}
                            </a>
                        </p>
                    @endif
                </div>
            </div>
            <hr class="border-light opacity-25 my-4">
            <div class="d-flex flex-column flex-sm-row justify-content-between small">
                <span>&copy; {{ date('Y') }} {{ config('salon.name') }}</span>
                <a class="text-decoration-none opacity-75" href="{{ route('login') }}">Masuk admin</a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
