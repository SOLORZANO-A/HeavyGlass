

<?php $__env->startSection('title', 'New Vehicle'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Registrar Vehiculo</h3>
            </div>

            <form action="<?php echo e(route('vehicles.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="card-body">

                    <div class="form-group">
                        <label>Dueño / Cliente</label>
                        <select name="client_id" id="client_id"
                            class="form-control select2 <?php $__errorArgs = ['client_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <option value="">-- Selecciona Cliente --</option>
                            <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($client->id); ?>" <?php echo e(old('client_id') == $client->id ? 'selected' : ''); ?>>
                                    <?php echo e($client->fullName()); ?> (<?php echo e($client->document); ?>)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['client_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="invalid-feedback"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Marca</label>
                                <input type="text" name="brand"
                                    class="form-control <?php $__errorArgs = ['brand'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('brand')); ?>">
                                <?php $__errorArgs = ['brand'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Modelo</label>
                                <input type="text" name="model"
                                    class="form-control <?php $__errorArgs = ['model'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('model')); ?>">
                                <?php $__errorArgs = ['model'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Placa</label>
                                <input type="text" name="plate"
                                    class="form-control <?php $__errorArgs = ['plate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('plate')); ?>">
                                <?php $__errorArgs = ['plate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Año</label>
                                <input type="number" name="year" class="form-control" value="<?php echo e(old('year')); ?>">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Color</label>
                                <input type="text" name="color" class="form-control" value="<?php echo e(old('color')); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Descripcion</label>
                        <textarea name="description" class="form-control" rows="3"><?php echo e(old('description')); ?></textarea>
                    </div>

                </div>

                <div class="card-footer">
                    <a href="<?php echo e(route('vehicles.index')); ?>" class="btn btn-secondary">
                        Cancelar
                    </a>

                    <button type="submit" class="btn btn-primary">
                        Guardar
                    </button>
                </div>

            </form>
        </div>

    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('styles'); ?>
    <style>
        /* Select2 altura igual a inputs */
        .select2-container .select2-selection--single {
            height: 38px;
            padding: 4px 8px;
            border: 1px solid #ced4da;
            border-radius: .25rem;
        }

        .select2-selection__rendered {
            line-height: 28px !important;
        }

        .select2-selection__arrow {
            height: 36px;
        }

        /* Mejor dropdown */
        .select2-dropdown {
            border-radius: .25rem;
        }
    </style>
<?php $__env->stopPush(); ?>


<?php $__env->startPush('scripts'); ?>
    <script>
        $(document).ready(function() {
            $('#client_id').select2({
                placeholder: 'Escriba nombre o cédula del cliente',
                allowClear: true,
                width: '100%',
                minimumResultsForSearch: 0, // 👈 SIEMPRE muestra el textbox
                matcher: function(params, data) {
                    if ($.trim(params.term) === '') {
                        return data; // 👈 si no hay texto → muestra TODO
                    }

                    if (typeof data.text === 'undefined') {
                        return null;
                    }

                    if (data.text.toLowerCase().includes(params.term.toLowerCase())) {
                        return data; // 👈 filtra mientras escribes
                    }

                    return null;
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\TitulacionHeavy-respaldo\resources\views/vehicles/create.blade.php ENDPATH**/ ?>