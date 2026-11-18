<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
    <h1 class="h3 mb-4">Dashboard</h1>

    <div class="row g-3 mb-4">
        <div class="col-sm-4">
            <div class="card card-salon h-100"><div class="card-body">
                <div class="small text-secondary">Menunggu konfirmasi</div>
                <div class="display-6"><?php echo e($pendingCount); ?></div>
            </div></div>
        </div>
        <div class="col-sm-4">
            <div class="card card-salon h-100"><div class="card-body">
                <div class="small text-secondary">Booking hari ini</div>
                <div class="display-6"><?php echo e($todayCount); ?></div>
            </div></div>
        </div>
        <div class="col-sm-4">
            <div class="card card-salon h-100"><div class="card-body">
                <div class="small text-secondary">Layanan aktif</div>
                <div class="display-6"><?php echo e($serviceCount); ?></div>
            </div></div>
        </div>
    </div>

    <div class="card card-salon">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="h5 mb-0">Perlu dikonfirmasi</h2>
                <a href="<?php echo e(route('admin.bookings.index', ['status' => 'menunggu'])); ?>" class="small">Lihat semua</a>
            </div>

            <?php $__empty_1 = true; $__currentLoopData = $pending; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="d-flex justify-content-between border-top py-2">
                    <div>
                        <strong><?php echo e($booking->customer_name); ?></strong>
                        <div class="small text-secondary"><?php echo e($booking->service->name); ?></div>
                    </div>
                    <div class="text-end small">
                        <?php echo e($booking->booking_date->translatedFormat('D, j M')); ?><br><?php echo e($booking->timeLabel()); ?>

                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-secondary mb-0">Tidak ada booking yang menunggu.</p>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\salon-booking\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>