<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $__env->yieldContent('title', config('salon.tagline')); ?> | <?php echo e(config('salon.name')); ?></title>
    <meta name="description" content="<?php echo $__env->yieldContent('description', config('salon.name').' - '.config('salon.tagline').'. Booking online mudah, langsung konfirmasi lewat WhatsApp.'); ?>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?php echo e(asset('css/salon.css')); ?>" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-salon sticky-top">
        <div class="container">
            <a class="navbar-brand fs-4" href="<?php echo e(route('home')); ?>"><?php echo e(config('salon.name')); ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu"
                    aria-controls="menu" aria-expanded="false" aria-label="Buka menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                    <li class="nav-item">
                        <a class="nav-link <?php if(request()->routeIs('home')): ?> active <?php endif; ?>" href="<?php echo e(route('home')); ?>">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if(request()->routeIs('services.index')): ?> active <?php endif; ?>" href="<?php echo e(route('services.index')); ?>">Layanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if(request()->routeIs('gallery')): ?> active <?php endif; ?>" href="<?php echo e(route('gallery')); ?>">Galeri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if(request()->routeIs('contact')): ?> active <?php endif; ?>" href="<?php echo e(route('contact')); ?>">Kontak</a>
                    </li>
                    <li class="nav-item mt-2 mt-lg-0">
                        <a class="btn btn-salon btn-sm" href="<?php echo e(route('booking.create')); ?>">Booking Sekarang</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="flex-grow-1">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <footer class="site-footer mt-5 pt-5 pb-4">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-5">
                    <h5 class="font-display"><?php echo e(config('salon.name')); ?></h5>
                    <p class="mb-0"><?php echo e(config('salon.tagline')); ?></p>
                </div>
                <div class="col-md-4">
                    <h5 class="font-display">Kunjungi Kami</h5>
                    <p class="mb-1"><i class="bi bi-geo-alt me-2"></i><?php echo e(config('salon.address')); ?></p>
                    <p class="mb-0"><i class="bi bi-clock me-2"></i><?php echo e(config('salon.open_text')); ?></p>
                </div>
                <div class="col-md-3">
                    <h5 class="font-display">Hubungi Kami</h5>
                    <p class="mb-1">
                        <a class="text-decoration-none" href="https://wa.me/<?php echo e(config('salon.whatsapp')); ?>" target="_blank" rel="noopener">
                            <i class="bi bi-whatsapp me-2"></i>WhatsApp
                        </a>
                    </p>
                    <?php if(config('salon.instagram')): ?>
                        <p class="mb-0">
                            <a class="text-decoration-none" href="https://instagram.com/<?php echo e(config('salon.instagram')); ?>" target="_blank" rel="noopener">
                                <i class="bi bi-instagram me-2"></i><?php echo e('@'.config('salon.instagram')); ?>

                            </a>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
            <hr class="border-light opacity-25 my-4">
            <div class="d-flex flex-column flex-sm-row justify-content-between small">
                <span>&copy; <?php echo e(date('Y')); ?> <?php echo e(config('salon.name')); ?></span>
                <a class="text-decoration-none opacity-75" href="<?php echo e(route('login')); ?>">Masuk admin</a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\laragon\www\salon-booking\resources\views/layouts/app.blade.php ENDPATH**/ ?>