<?php $__env->startSection('title', 'Galeri'); ?>

<?php $__env->startSection('content'); ?>
    <section class="section">
        <div class="container">
            <div class="text-center mb-5">
                <p class="eyebrow mb-2">Galeri</p>
                <h1 class="h2">Hasil Kerja &amp; Suasana Salon</h1>
            </div>

            <?php if($photos->isEmpty()): ?>
                <p class="text-center text-secondary">Foto belum tersedia.</p>
            <?php else: ?>
                <div class="row g-3">
                    <?php $__currentLoopData = $photos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-6 col-md-4 col-lg-3">
                            <button type="button" class="gallery-thumb ratio ratio-1x1" data-bs-toggle="modal"
                                    data-bs-target="#photoModal" data-photo="<?php echo e($photo['url']); ?>"
                                    data-title="<?php echo e($photo['title']); ?>" aria-label="Perbesar foto <?php echo e($photo['title'] ?: $loop->iteration); ?>">
                                <img src="<?php echo e($photo['url']); ?>" alt="<?php echo e($photo['title'] ?: 'Foto galeri '.$loop->iteration); ?>" loading="lazy">
                            </button>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <div class="modal fade" id="photoModal" tabindex="-1" aria-label="Foto diperbesar" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 bg-transparent">
                <img id="photoModalImage" src="" alt="Foto diperbesar" class="img-fluid rounded-4" data-bs-dismiss="modal">
                <p id="photoModalTitle" class="text-white text-center mt-2 mb-0"></p>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.getElementById('photoModal').addEventListener('show.bs.modal', function (event) {
            document.getElementById('photoModalImage').src = event.relatedTarget.dataset.photo;
            document.getElementById('photoModalTitle').textContent = event.relatedTarget.dataset.title || '';
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\salon-booking\resources\views\pages\gallery.blade.php ENDPATH**/ ?>