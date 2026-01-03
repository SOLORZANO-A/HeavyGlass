

<?php $__env->startSection('title', 'Work Type Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">

    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Informacion del tipo de trabajo</h3>

            <div class="card-tools">
                <a href="<?php echo e(route('work_types.edit', $workType)); ?>" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Editar
                </a>

                <a href="<?php echo e(route('work_types.index')); ?>" class="btn btn-secondary btn-sm">
                    Atras
                </a>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="200">Nombre</th>
                    <td><?php echo e($workType->name); ?></td>
                </tr>
                <tr>
                    <th>Descripción</th>
                    <td><?php echo e($workType->description ?? '—'); ?></td>
                </tr>
                <tr>
                    <th>Hora de creación</th>
                    <td><?php echo e($workType->created_at->format('Y-m-d H:i')); ?></td>
                </tr>
            </table>
        </div>

        <div class="card-footer">
            <a href="<?php echo e(route('work_types.index')); ?>" class="btn btn-secondary">
                Regresar a la lista
            </a>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\TitulacionHeavy-respaldo\resources\views/work_types/show.blade.php ENDPATH**/ ?>