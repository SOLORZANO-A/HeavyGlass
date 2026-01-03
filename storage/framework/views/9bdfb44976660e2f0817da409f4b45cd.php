

<?php $__env->startSection('title', 'New Proforma'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Crea la proforma</h3>
            </div>

            <form action="<?php echo e(route('proformas.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="card-body">

                    
                    <div class="form-group">
                        <label>Orden de trabajo</label>

                        <select name="work_order_id" class="form-control select2 <?php $__errorArgs = ['work_order_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            required>

                            <option value="">-- Selecciona la Orden de Trabajo --</option>

                            <?php $__currentLoopData = $workOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($order->id); ?>">
                                    #<?php echo e($order->id); ?>

                                    - <?php echo e($order->intakeSheet->vehicle->plate); ?>

                                    | <?php echo e($order->intakeSheet->vehicle->brand); ?>

                                    <?php echo e($order->intakeSheet->vehicle->model); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </select>

                        <?php $__errorArgs = ['work_order_id'];
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


                    <hr>

                    <h5>Detalles Proforma</h5>

                    <div id="details-wrapper">
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <input type="text" name="details[0][description]" class="form-control"
                                    placeholder="Descripción" required>
                            </div>
                            <div class="col-md-3">
                                <input type="number" step="0.01" name="details[0][price]" class="form-control"
                                    placeholder="Precio unitario" required>
                            </div>
                            <div class="col-md-3">
                                <input type="number" name="details[0][quantity]" class="form-control"
                                    placeholder="Cantidad" value="1" min="1" required>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-sm btn-secondary mb-3" onclick="addDetailRow()">
                        <i class="fas fa-plus"></i> Agregar Items
                    </button>

                    <div class="form-group">
                        <label>Observaciones</label>
                        <textarea name="observations" class="form-control" rows="3"><?php echo e(old('observations')); ?></textarea>
                    </div>

                </div>

                <div class="card-footer">
                    <a href="<?php echo e(route('proformas.index')); ?>" class="btn btn-secondary">
                        Cancelar
                    </a>

                    <button type="submit" class="btn btn-primary">
                        Crear Proforma
                    </button>
                </div>

            </form>
        </div>

    </div>

    <script>
        let detailIndex = 1;

        function addDetailRow() {
            const wrapper = document.getElementById('details-wrapper');

            const row = document.createElement('div');
            row.classList.add('row', 'mb-2');

            row.innerHTML = `
        <div class="col-md-6">
            <input type="text"
                   name="details[${detailIndex}][description]"
                   class="form-control"
                   placeholder="Description"
                   required>
        </div>
        <div class="col-md-3">
            <input type="number"
                   step="0.01"
                   name="details[${detailIndex}][price]"
                   class="form-control"
                   placeholder="Price"
                   required>
        </div>
        <div class="col-md-3">
            <input type="number"
                   name="details[${detailIndex}][quantity]"
                   class="form-control"
                   placeholder="Qty"
                   value="1"
                   min="1"
                   required>
        </div>
    `;

            wrapper.appendChild(row);
            detailIndex++;
        }
    </script>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Seleccione una orden de trabajo',
                allowClear: true,
                width: '100%'
            });
        });
    </script>
<?php $__env->stopPush(); ?>
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
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\TitulacionHeavy-respaldo\resources\views/proformas/create.blade.php ENDPATH**/ ?>