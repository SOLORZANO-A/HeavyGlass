

<?php $__env->startSection('title', 'New Work Order'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Creación Orden de Trabajo</h3>
            </div>

            <form action="<?php echo e(route('work_orders.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="card-body">

                    
                    <div class="form-group">
                        <label>Vehiculo / Hoja de ingreso</label>
                        <select name="intake_sheet_id" id="intake_sheet_id" class="form-control select2" required>

                            <option value="">Seleccione la hoja de ingreso</option>

                            <?php $__currentLoopData = $intakeSheets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sheet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($sheet->id); ?>">
                                    #<?php echo e($sheet->id); ?>

                                    | <?php echo e($sheet->vehicle->plate); ?>

                                    | <?php echo e($sheet->vehicle->brand); ?> <?php echo e($sheet->vehicle->model); ?>

                                    | <?php echo e($sheet->created_at->format('Y-m-d')); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>

                    </div>

                    
                    <div class="form-group">
                        <label>Tipo de Trabajo</label>
                        <select name="work_type_ids[]" class="form-control" multiple required>
                            <?php $__currentLoopData = $workTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($type->id); ?>">
                                    <?php echo e($type->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>


                    
                    <div class="form-group">
                        <label>Técnicos asignados</label>

                        <select name="technicians[]" class="form-control select2" multiple required>

                            <?php $__currentLoopData = $technicians; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tech): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($tech->id); ?>">
                                    <?php echo e($tech->fullName()); ?>

                                    <?php if($tech->specialization): ?>
                                        (<?php echo e($tech->specialization); ?>)
                                    <?php endif; ?>
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </select>
                    </div>




                    <div class="form-group">
                        <label>Fecha de inicio</label>
                        <input type="date" name="started_at" class="form-control" value="<?php echo e(old('started_at')); ?>">
                    </div>



                    
                    <div class="form-group">
                        <label>Estado</label>
                        <select name="status" class="form-control" required>
                            <option value="pending">Pendiente</option>
                            <option value="in_progress">En proceso</option>
                            <option value="paused">Pausado</option>
                            <option value="completed">Completo</option>
                        </select>
                    </div>

                    
                    <div class="form-group">
                        <label>Descripción</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>

                </div>

                <div class="card-footer">
                    <a href="<?php echo e(route('work_orders.index')); ?>" class="btn btn-secondary">
                        Cancelar
                    </a>
                    <button class="btn btn-primary">Guardar orden de trabajo</button>
                </div>
            </form>

        </div>

    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script>
        $('#intake_sheet_id').select2({
            placeholder: 'Buscar por placa, ID o fecha',
            allowClear: true,
            width: '100%',
            minimumResultsForSearch: 0,
            matcher: function(params, data) {

                if ($.trim(params.term) === '') {
                    return data;
                }

                if (typeof data.text === 'undefined') {
                    return null;
                }

                if (data.text.toLowerCase().includes(params.term.toLowerCase())) {
                    return data;
                }

                return null;
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Seleccione uno o más técnicos',
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\TitulacionHeavy-respaldo\resources\views/work_orders/create.blade.php ENDPATH**/ ?>