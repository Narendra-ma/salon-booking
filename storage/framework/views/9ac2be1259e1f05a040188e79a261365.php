<?php $__env->startSection('title', 'Layanan & Harga'); ?>

<?php $__env->startSection('content'); ?>
    <section class="section">
        <div class="container">
            <div class="text-center mb-5">
                <p class="eyebrow mb-2">Layanan &amp; Harga</p>
                <h1 class="h2">Pilih Perawatan Anda</h1>
                <p class="mb-0">Harga dapat berubah sewaktu-waktu, tanyakan kami untuk paket atau promo terbaru.</p>
            </div>

            <?php if($services->isEmpty()): ?>
                <p class="text-center text-secondary">Daftar layanan belum tersedia.</p>
            <?php else: ?>
                <div class="row g-4">
                    <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-6 col-lg-4">
                            <?php echo $__env->make('services._card', ['service' => $service], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\salon-booking\resources\views\services\index.blade.php ENDPATH**/ ?>