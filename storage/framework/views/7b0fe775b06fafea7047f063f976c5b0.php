<?php $__env->startSection('title', 'Booking'); ?>

<?php $__env->startSection('content'); ?>
    <h1 class="h3 mb-3">Booking</h1>

    <form method="GET" class="row g-2 align-items-end mb-3">
        <div class="col-sm-4 col-md-3">
            <label for="status" class="form-label small mb-1">Status</label>
            <select id="status" name="status" class="form-select">
                <option value="">Semua</option>
                <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($status->value); ?>" <?php if(request('status') === $status->value): echo 'selected'; endif; ?>><?php echo e($status->label()); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-sm-4 col-md-3">
            <label for="tanggal" class="form-label small mb-1">Tanggal</label>
            <input type="date" id="tanggal" name="tanggal" value="<?php echo e(request('tanggal')); ?>" class="form-control">
        </div>
        <div class="col-sm-4 col-md-3">
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="riwayat" name="riwayat" value="1" <?php if(request()->boolean('riwayat')): echo 'checked'; endif; ?>>
                <label class="form-check-label small" for="riwayat">Termasuk yang sudah lewat</label>
            </div>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button class="btn btn-salon">Terapkan</button>
            <a href="<?php echo e(route('admin.bookings.index')); ?>" class="btn btn-outline-secondary rounded-pill">Reset</a>
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
                    <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="text-nowrap">
                                <?php echo e($booking->booking_date->translatedFormat('D, j M Y')); ?><br>
                                <span class="small text-secondary"><?php echo e($booking->timeLabel()); ?></span>
                            </td>
                            <td>
                                <?php echo e($booking->customer_name); ?><br>
                                <span class="small text-secondary">+<?php echo e($booking->customer_phone); ?></span>
                            </td>
                            <td><?php echo e($booking->service->name); ?></td>
                            <td><?php echo e($booking->employee?->name ?? '-'); ?></td>
                            <td><span class="badge <?php echo e($booking->status->badge()); ?>"><?php echo e($booking->status->label()); ?></span></td>
                            <td class="text-end text-nowrap">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('approve', $booking)): ?>
                                    <form method="POST" action="<?php echo e(route('admin.bookings.approve', $booking)); ?>" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <button class="btn btn-sm btn-success">Setujui</button>
                                    </form>
                                <?php endif; ?>

                                <?php if($booking->status === \App\Enums\BookingStatus::Disetujui): ?>
                                    <a href="<?php echo e($booking->whatsappUrl()); ?>" target="_blank" rel="noopener" class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-whatsapp"></i> Kirim WA
                                    </a>
                                <?php endif; ?>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cancel', $booking)): ?>
                                    <form method="POST" action="<?php echo e(route('admin.bookings.cancel', $booking)); ?>" class="d-inline"
                                          onsubmit="return confirm('Batalkan booking <?php echo e(e($booking->customer_name)); ?>?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <button class="btn btn-sm btn-outline-danger">Batalkan</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="6" class="text-center text-secondary py-4">Tidak ada booking.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3"><?php echo e($bookings->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\salon-booking\resources\views/admin/bookings/index.blade.php ENDPATH**/ ?>