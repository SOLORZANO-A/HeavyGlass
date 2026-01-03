

<?php $__env->startSection('title', 'Edit Work Type'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">

    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">Editar tipo de trabajo</h3>
        </div>

        <form action="<?php echo e(route('work_types.update', $workType)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="card-body">

                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text"
                           name="name"
                           class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           value="<?php echo e(old('name', $workType->name)); ?>">
                    <?php $__errorArgs = ['name'];
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
                    <textarea name="description"
                              class="form-control"
                              rows="3"><?php echo e(old('description', $workType->description)); ?></textarea>
                </div>

            </div>

            <div class="card-footer">
                <a href="<?php echo e(route('work_types.show', $workType)); ?>" class="btn btn-secondary">
                    Cancelar
                </a>

                <button type="submit" class="btn btn-warning">
                    Actualizar
                </button>
            </div>

        </form>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\TitulacionHeavy-respaldo\resources\views/work_types/edit.blade.php ENDPATH**/ ?>