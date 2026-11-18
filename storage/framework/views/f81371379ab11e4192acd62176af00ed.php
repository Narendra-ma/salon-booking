<?php $__env->startSection('title', 'Beranda'); ?>

<?php $__env->startSection('content'); ?>
    <section class="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <p class="eyebrow mb-3">Salon &amp; Perawatan Kecantikan</p>
                    <h1 class="display-4 mb-3"><?php echo e(config('salon.tagline')); ?></h1>
                    <p class="lead mb-4">
                        Rias wedding, creambath, facial, nail gel, dan eyelash extension dirawat dengan telaten di <?php echo e(config('salon.name')); ?>.
                        Pilih jadwal Anda secara online, kami konfirmasi lewat WhatsApp.
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="<?php echo e(route('booking.create')); ?>" class="btn btn-salon btn-lg">Booking Sekarang</a>
                        <a href="<?php echo e(route('services.index')); ?>" class="btn btn-salon-outline btn-lg">Lihat Layanan</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row g-4 text-center">
                <div class="col-md-4">
                    <span class="icon-circle mb-3"><i class="bi bi-scissors"></i></span>
                    <h3 class="h5">Pegawai Berpengalaman</h3>
                    <p class="mb-0">Ditangani langsung oleh tim yang sudah terbiasa dengan berbagai jenis rambut dan kulit.</p>
                </div>
                <div class="col-md-4">
                    <span class="icon-circle mb-3"><i class="bi bi-flower1"></i></span>
                    <h3 class="h5">Suasana Nyaman</h3>
                    <p class="mb-0">Tempat yang tenang dan bersih, cocok untuk melepas lelah setelah beraktivitas.</p>
                </div>
                <div class="col-md-4">
                    <span class="icon-circle mb-3"><i class="bi bi-calendar-check"></i></span>
                    <h3 class="h5">Booking Mudah</h3>
                    <p class="mb-0">Tanpa antre. Pilih layanan, tanggal, dan jam, lalu tunggu konfirmasi dari kami.</p>
                </div>
            </div>
        </div>
    </section>

    <?php if($services->isNotEmpty()): ?>
        <section class="section section-alt">
            <div class="container">
                <div class="text-center mb-5">
                    <p class="eyebrow mb-2">Layanan Kami</p>
                    <h2>Perawatan Pilihan</h2>
                </div>
                <div class="row g-4">
                    <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-6 col-lg-4">
                            <?php echo $__env->make('services._card', ['service' => $service], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="text-center mt-5">
                    <a href="<?php echo e(route('services.index')); ?>" class="btn btn-salon-outline">Semua Layanan</a>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section class="section">
        <div class="container">
            <div class="cta-band rounded-4 p-5 text-center">
                <h2 class="mb-2">Siap tampil lebih segar?</h2>
                <p class="mb-4">Amankan jadwal Anda sekarang, slot favorit cepat terisi.</p>
                <a href="<?php echo e(route('booking.create')); ?>" class="btn btn-light rounded-pill px-4">Booking Sekarang</a>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\salon-booking\resources\views/pages/home.blade.php ENDPATH**/ ?>