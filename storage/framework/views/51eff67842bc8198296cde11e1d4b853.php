<?php $__env->startSection('title', 'Layanan'); ?>

<?php $__env->startSection('content'); ?>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Layanan</h1>
        <a href="<?php echo e(route('admin.services.create')); ?>" class="btn btn-salon">Tambah Layanan</a>
    </div>

    <div class="card card-salon">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Durasi</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($service->name); ?></td>
                            <td class="text-nowrap"><?php echo e($service->durationLabel()); ?></td>
                            <td class="text-nowrap"><?php echo e($service->priceLabel()); ?></td>
                            <td>
                                <span class="badge <?php echo e($service->is_active ? 'text-bg-success' : 'text-bg-secondary'); ?>">
                                    <?php echo e($service->is_active ? 'Aktif' : 'Nonaktif'); ?>

                                </span>
                            </td>
                            <td class="text-end text-nowrap">
                                <a href="<?php echo e(route('admin.services.edit', $service)); ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
                                <form method="POST" action="<?php echo e(route('admin.services.destroy', $service)); ?>" class="d-inline"
                                      onsubmit="return confirm('Hapus layanan <?php echo e(e($service->name)); ?>?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-sm btn-outline-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="5" class="text-center text-secondary py-4">Belum ada layanan.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3"><?php echo e($services->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\salon-booking\resources\views/admin/services/index.blade.php ENDPATH**/ ?>