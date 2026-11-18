<?php $__env->startSection('title', 'Booking'); ?>

<?php $__env->startSection('content'); ?>
    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-xl-6">
                    <div class="text-center mb-4">
                        <p class="eyebrow mb-2">Booking Online</p>
                        <h1 class="h2">Pilih Jadwal Anda</h1>
                    </div>

                    <?php if(session('booking_summary')): ?>
                        <?php ($summary = session('booking_summary')); ?>
                        <div class="card card-salon">
                            <div class="card-body p-4 text-center">
                                <span class="icon-circle mb-3"><i class="bi bi-check2-circle"></i></span>
                                <h2 class="h4">Terima kasih, <?php echo e($summary['name']); ?>!</h2>
                                <p>Booking Anda sudah kami terima dan <strong>menunggu konfirmasi</strong>. Kami akan menghubungi Anda lewat WhatsApp.</p>
                                <ul class="list-unstyled mb-4">
                                    <li><strong>Layanan:</strong> <?php echo e($summary['service']); ?></li>
                                    <li><strong>Tanggal:</strong> <?php echo e($summary['date']); ?></li>
                                    <li><strong>Jam:</strong> <?php echo e($summary['time']); ?> WIB</li>
                                </ul>
                                <a href="<?php echo e(route('home')); ?>" class="btn btn-salon-outline">Kembali ke Beranda</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="card card-salon">
                            <div class="card-body p-4">
                                <form method="POST" action="<?php echo e(route('booking.store')); ?>" novalidate>
                                    <?php echo csrf_field(); ?>

                                    <div class="mb-3">
                                        <label for="customer_name" class="form-label">Nama</label>
                                        <input type="text" id="customer_name" name="customer_name"
                                               class="form-control <?php $__errorArgs = ['customer_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               value="<?php echo e(old('customer_name')); ?>" maxlength="100" required autocomplete="name">
                                        <?php $__errorArgs = ['customer_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="mb-3">
                                        <label for="customer_phone" class="form-label">Nomor WhatsApp</label>
                                        <input type="tel" id="customer_phone" name="customer_phone"
                                               class="form-control <?php $__errorArgs = ['customer_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               value="<?php echo e(old('customer_phone')); ?>" placeholder="0812-3456-7890" required autocomplete="tel">
                                        <?php $__errorArgs = ['customer_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="mb-3">
                                        <label for="service_id" class="form-label">Layanan</label>
                                        <select id="service_id" name="service_id"
                                                class="form-select <?php $__errorArgs = ['service_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                            <option value="">Pilih layanan</option>
                                            <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($service->id); ?>" <?php if(old('service_id', $selectedService) == $service->id): echo 'selected'; endif; ?>>
                                                    <?php echo e($service->name); ?> - <?php echo e($service->durationLabel()); ?> - <?php echo e($service->priceLabel()); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php $__errorArgs = ['service_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6 mb-3">
                                            <label for="booking_date" class="form-label">Tanggal</label>
                                            <input type="date" id="booking_date" name="booking_date"
                                                   class="form-control <?php $__errorArgs = ['booking_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                   value="<?php echo e(old('booking_date')); ?>" min="<?php echo e($minDate); ?>" max="<?php echo e($maxDate); ?>" required>
                                            <?php $__errorArgs = ['booking_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <label for="start_time" class="form-label">Jam</label>
                                            <select id="start_time" name="start_time"
                                                    class="form-select <?php $__errorArgs = ['start_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                                <option value="">Pilih jam</option>
                                                <?php $__currentLoopData = $slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($slot); ?>" <?php if(old('start_time') === $slot): echo 'selected'; endif; ?>><?php echo e($slot); ?> WIB</option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <?php $__errorArgs = ['start_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-salon btn-lg">Kirim Booking</button>
                                    </div>
                                    <p class="small text-secondary text-center mt-3 mb-0">
                                        Booking baru berstatus <em>menunggu</em> sampai kami konfirmasi lewat WhatsApp.
                                    </p>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\salon-booking\resources\views\booking\create.blade.php ENDPATH**/ ?>