<?php $__env->startSection('title', 'Kontak'); ?>

<?php $__env->startSection('content'); ?>
    <section class="section">
        <div class="container">
            <div class="text-center mb-5">
                <p class="eyebrow mb-2">Kontak</p>
                <h1 class="h2">Temui Kami di Surabaya</h1>
            </div>

            <div class="row g-4">
                <div class="col-lg-5">
                    <div class="card card-salon h-100">
                        <div class="card-body p-4">
                            <div class="d-flex mb-4">
                                <span class="icon-circle me-3 flex-shrink-0"><i class="bi bi-geo-alt"></i></span>
                                <div>
                                    <h2 class="h6 mb-1">Alamat</h2>
                                    <p class="mb-0"><?php echo e(config('salon.address')); ?></p>
                                </div>
                            </div>
                            <div class="d-flex mb-4">
                                <span class="icon-circle me-3 flex-shrink-0"><i class="bi bi-clock"></i></span>
                                <div>
                                    <h2 class="h6 mb-1">Jam Buka</h2>
                                    <p class="mb-0"><?php echo e(config('salon.open_text')); ?></p>
                                </div>
                            </div>
                            <div class="d-flex mb-4">
                                <span class="icon-circle me-3 flex-shrink-0"><i class="bi bi-telephone"></i></span>
                                <div>
                                    <h2 class="h6 mb-1">Telepon</h2>
                                    <p class="mb-0"><?php echo e(config('salon.phone')); ?></p>
                                </div>
                            </div>
                            <div class="d-grid gap-2">
                                <a class="btn btn-salon" href="https://wa.me/<?php echo e(config('salon.whatsapp')); ?>" target="_blank" rel="noopener">
                                    <i class="bi bi-whatsapp me-2"></i>Chat WhatsApp
                                </a>
                                <a class="btn btn-salon-outline" href="https://www.google.com/maps/search/?api=1&query=<?php echo e(urlencode(config('salon.map_query'))); ?>" target="_blank" rel="noopener">
                                    <i class="bi bi-signpost-split me-2"></i>Buka di Google Maps
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="ratio ratio-4x3">
                        <iframe class="map-frame" title="Lokasi <?php echo e(config('salon.name')); ?>" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                src="https://www.google.com/maps?q=<?php echo e(urlencode(config('salon.map_query'))); ?>&output=embed"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\salon-booking\resources\views\pages\contact.blade.php ENDPATH**/ ?>