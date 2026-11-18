<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title><?php echo $__env->yieldContent('title'); ?> | Admin <?php echo e(config('salon.name')); ?></title>

    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?php echo e(asset('css/salon.css')); ?>" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-admin">
        <div class="container">
            <a class="navbar-brand" href="<?php echo e(route('admin.dashboard')); ?>">Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminMenu"
                    aria-controls="adminMenu" aria-expanded="false" aria-label="Buka menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminMenu">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php if(request()->routeIs('admin.dashboard')): ?> active <?php endif; ?>" href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if(request()->routeIs('admin.bookings.*')): ?> active <?php endif; ?>" href="<?php echo e(route('admin.bookings.index')); ?>">Booking</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if(request()->routeIs('admin.services.*')): ?> active <?php endif; ?>" href="<?php echo e(route('admin.services.index')); ?>">Layanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if(request()->routeIs('admin.gallery.*')): ?> active <?php endif; ?>" href="<?php echo e(route('admin.gallery.index')); ?>">Galeri</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <a class="nav-link text-white-50 p-0" href="<?php echo e(route('home')); ?>" target="_blank">Lihat situs</a>
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-sm btn-outline-light">Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH C:\laragon\www\salon-booking\resources\views\layouts\admin.blade.php ENDPATH**/ ?>