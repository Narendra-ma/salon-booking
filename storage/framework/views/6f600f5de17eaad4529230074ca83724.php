<?php $__env->startSection('title', 'Edit Layanan'); ?>

<?php $__env->startSection('content'); ?>
    <h1 class="h3 mb-3">Edit Layanan</h1>
    <div class="card card-salon">
        <div class="card-body p-4">
            <form method="POST" action="<?php echo e(route('admin.services.update', $service)); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <?php echo $__env->make('admin.services._form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\salon-booking\resources\views\admin\services\edit.blade.php ENDPATH**/ ?>