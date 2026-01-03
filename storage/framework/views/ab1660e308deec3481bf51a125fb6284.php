

<?php $__env->startSection('title', 'Edit Work Order'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">

        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Editar Orden de TRabajo</h3>
            </div>

            <form action="<?php echo e(route('work_orders.update', $workOrder)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="card-body">

                    
                    <div class="form-group">
                        <label>Vehiculo / Hoja de Ingreso</label>
                        <select name="intake_sheet_id" class="form-control" required>
                            <?php $__currentLoopData = $intakeSheets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sheet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($sheet->id); ?>"
                                    <?php echo e($sheet->id == old('intake_sheet_id', $workOrder->intake_sheet_id) ? 'selected' : ''); ?>>
                                    <?php echo e($sheet->vehicle->brand); ?>

                                    <?php echo e($sheet->vehicle->model); ?>

                                    - <?php echo e($sheet->vehicle->plate); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    
                    <div class="form-group">
                        <label>Tipo de Trabajo</label>
                        <select name="work_type_ids[]" class="form-control" multiple required>
                            <?php $__currentLoopData = $workTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($type->id); ?>"
                                    <?php echo e(in_array($type->id, old('work_type_ids', $workOrder->workTypes->pluck('id')->toArray())) ? 'selected' : ''); ?>>
                                    <?php echo e($type->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>

                    </div>

                    
                    <div class="form-group">
                        <label>Técnicos asignados</label>

                        <select name="technicians[]" class="form-control select2" multiple required>

                            <?php $__currentLoopData = $technicians; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tech): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($tech->id); ?>"
                                    <?php echo e($workOrder->technicians->contains($tech->id) ? 'selected' : ''); ?>>
                                    <?php echo e($tech->first_name); ?> <?php echo e($tech->last_name); ?>

                                    <?php if($tech->specialization): ?>
                                        (<?php echo e($tech->specialization); ?>)
                                    <?php endif; ?>
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </select>
                    </div>


                    
                    <div class="form-group">
                        <label>Estado</label>
                        <select name="status" class="form-control" required>
                            <?php
                                $statuses = [
                                    'pending' => 'Pendiente',
                                    'in_progress' => 'En progreso',
                                    'paused' => 'Pausado',
                                    'completed' => 'Completado',
                                ];
                            ?>

                            <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value); ?>"
                                    <?php echo e($value == old('status', $workOrder->status) ? 'selected' : ''); ?>>
                                    <?php echo e($label); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Fecha de inicio</label>
                        <input type="date" name="started_at"
                            class="form-control <?php $__errorArgs = ['started_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            value="<?php echo e(old('started_at', optional($workOrder->started_at)->format('Y-m-d'))); ?>">

                        <?php $__errorArgs = ['started_at'];
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



                    
                    <div class="form-group">
                        <label>Descripcion</label>
                        <textarea name="description" class="form-control" rows="3"><?php echo e(old('description', $workOrder->description)); ?></textarea>
                    </div>

                </div>

                <div class="card-footer">
                    <a href="<?php echo e(route('work_orders.index')); ?>" class="btn btn-secondary">Cancelar</a>
                    <button class="btn btn-warning">Actualizar Orden de Trabajo</button>
                </div>

            </form>

        </div>

    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
    $(document).ready(function () {
        $('.select2').select2({
            placeholder: 'Seleccione uno o más técnicos',
            width: '100%'
        });
    });
</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\TitulacionHeavy-respaldo\resources\views/work_orders/edit.blade.php ENDPATH**/ ?>