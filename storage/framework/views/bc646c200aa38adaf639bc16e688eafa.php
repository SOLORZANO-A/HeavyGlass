

<?php $__env->startSection('title', 'Intake Sheet Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">

    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">
                Hoja de Ingreso #<?php echo e($intakeSheet->id); ?>

            </h3>

            <div class="card-tools">
                <a href="<?php echo e(route('intake_sheets.edit', $intakeSheet)); ?>"
                   class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Editar
                </a>

                <a href="<?php echo e(route('intake_sheets.index')); ?>"
                   class="btn btn-secondary btn-sm">
                    Volver
                </a>
            </div>
        </div>

        <div class="card-body">

            <table class="table table-bordered">

                
                <tr>
                    <th width="250">Vehículo</th>
                    <td>
                        <?php echo e($intakeSheet->vehicle?->plate ?? '—'); ?> —
                        <?php echo e($intakeSheet->vehicle?->brand ?? ''); ?>

                        <?php echo e($intakeSheet->vehicle?->model ?? ''); ?>

                    </td>
                </tr>

                
                <tr>
                    <th>Cliente</th>
                    <td>
                        <?php echo e($intakeSheet->vehicle?->client?->fullName() ?? '—'); ?>

                    </td>
                </tr>

                
                <tr>
                    <th>Fecha de Ingreso</th>
                    <td>
                        <?php echo e($intakeSheet->entry_at
                            ? $intakeSheet->entry_at->format('Y-m-d H:i')
                            : '—'); ?>

                    </td>
                </tr>

                
                <tr>
                    <th>Kilometraje</th>
                    <td><?php echo e($intakeSheet->km_at_entry ?? '—'); ?></td>
                </tr>

                
                <tr>
                    <th>Nivel de Combustible</th>
                    <td><?php echo e(ucfirst($intakeSheet->fuel_level ?? '—')); ?></td>
                </tr>

                
                <tr>
                    <th>Condición del Vehículo</th>
                    <td>
                        <?php if($intakeSheet->has_dents): ?>
                            <span class="badge badge-warning">Abolladuras</span>
                        <?php endif; ?>

                        <?php if($intakeSheet->has_scratches): ?>
                            <span class="badge badge-info">Arañazos</span>
                        <?php endif; ?>

                        <?php if($intakeSheet->has_cracks): ?>
                            <span class="badge badge-danger">Grietas</span>
                        <?php endif; ?>

                        <?php if(
                            !$intakeSheet->has_dents &&
                            !$intakeSheet->has_scratches &&
                            !$intakeSheet->has_cracks
                        ): ?>
                            <span class="text-muted">Sin daños visibles</span>
                        <?php endif; ?>
                    </td>
                </tr>

                
                <tr>
                    <th>Objetos de Valor</th>
                    <td><?php echo e($intakeSheet->valuables ?? '—'); ?></td>
                </tr>

                
                <tr>
                    <th>Observaciones</th>
                    <td><?php echo e($intakeSheet->observations ?? '—'); ?></td>
                </tr>

                
                <tr>
                    <th>Fotos del Vehículo</th>
                    <td>
                        <?php if($intakeSheet->photos && $intakeSheet->photos->count()): ?>
                            <div class="row">
                                <?php $__currentLoopData = $intakeSheet->photos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-3 mb-3">
                                        <a href="<?php echo e(asset('storage/' . $photo->path)); ?>"
                                           target="_blank">
                                            <img src="<?php echo e(asset('storage/' . $photo->path)); ?>"
                                                 class="img-fluid img-thumbnail"
                                                 alt="Foto vehículo">
                                        </a>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <span class="text-muted">No hay fotos registradas</span>
                        <?php endif; ?>
                    </td>
                </tr>

            </table>

        </div>

        <div class="card-footer">
            <a href="<?php echo e(route('intake_sheets.index')); ?>" class="btn btn-secondary">
                Volver al listado
            </a>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\TitulacionHeavy-respaldo\resources\views/intake_sheets/show.blade.php ENDPATH**/ ?>