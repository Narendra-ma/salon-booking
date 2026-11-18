<?php $__env->startSection('title', 'Tambah Layanan'); ?>

<?php $__env->startSection('content'); ?>
    <h1 class="h3 mb-3">Tambah Layanan</h1>
    <div class="card card-salon">
        <div class="card-body p-4">
            <form method="POST" action="<?php echo e(route('admin.services.store')); ?>">
                <?php echo csrf_field(); ?>
                <?php echo $__env->make('admin.services._form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\salon-booking\resources\views\admin\services\create.blade.php ENDPATH**/ ?>