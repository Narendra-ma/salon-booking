

<?php $__env->startSection('title', 'Galeri'); ?>

<?php $__env->startSection('content'); ?>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Galeri Foto</h1>
    </div>

    <div class="card card-salon mb-4">
        <div class="card-body">
            <h2 class="h5">Tambah Foto</h2>
            <form method="POST" action="<?php echo e(route('admin.gallery.store')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label for="photo" class="form-label">Foto</label>
                        <input type="file" id="photo" name="photo" accept="image/jpeg,image/png,image/webp"
                               class="form-control <?php $__errorArgs = ['photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                        <?php $__errorArgs = ['photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <div class="form-text">JPG, PNG, atau WebP. Maksimal 5 MB.</div>
                    </div>
                    <div class="col-md-5">
                        <label for="title" class="form-label">Keterangan foto</label>
                        <input type="text" id="title" name="title" value="<?php echo e(old('title')); ?>" maxlength="150"
                               class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="Contoh: Rias pengantin pelanggan">
                        <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-salon w-100">Unggah</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-3">
        <?php $__empty_1 = true; $__currentLoopData = $photos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card card-salon h-100">
                    <img src="<?php echo e($photo->url()); ?>" class="card-img-top" alt="<?php echo e($photo->title ?: 'Foto galeri'); ?>"
                         style="height: 180px; object-fit: cover;">
                    <div class="card-body">
                        <p class="small mb-3"><?php echo e($photo->title ?: 'Tanpa keterangan'); ?></p>
                        <form method="POST" action="<?php echo e(route('admin.gallery.destroy', $photo)); ?>"
                              onsubmit="return confirm('Hapus foto ini dari galeri?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-outline-danger w-100">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12">
                <p class="text-center text-secondary py-4">Belum ada foto yang diunggah dari panel admin.</p>
            </div>
        <?php endif; ?>
    </div>

    <div class="mt-3"><?php echo e($photos->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\salon-booking\resources\views/admin/gallery/index.blade.php ENDPATH**/ ?>