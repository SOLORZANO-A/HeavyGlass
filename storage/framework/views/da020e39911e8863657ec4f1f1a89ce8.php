

<?php $__env->startSection('title', 'Editar Perfil'); ?>

<?php $__env->startSection('content'); ?>

<?php
    $staffTypeLabels = [
        'technician' => 'Técnico',
        'advisor' => 'Asesor',
        'cashier' => 'Cajero/a',
        'workshop_manager' => 'Jefe de Taller',
        'admin' => 'Administrador',
    ];

    $roleLabels = [
        'admin' => 'Administrador',
        'advisor' => 'Asesor',
        'cashier' => 'Cajero/a',
        'workshop_manager' => 'Jefe de Taller',
    ];
?>

<div class="container-fluid">
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">Editar Perfil</h3>
        </div>

        <form action="<?php echo e(route('profiles.update', $profile)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="card-body">

                
                <h5 class="mb-3">Información Personal</h5>

                <div class="row">
                    <div class="col-md-6">
                        <label>Primer Nombre</label>
                        <input type="text" name="first_name" class="form-control"
                               value="<?php echo e(old('first_name', $profile->first_name)); ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label>Apellido</label>
                        <input type="text" name="last_name" class="form-control"
                               value="<?php echo e(old('last_name', $profile->last_name)); ?>" required>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-4">
                        <label>Cédula de Identidad</label>
                        <input type="text" name="document" class="form-control"
                               value="<?php echo e(old('document', $profile->document)); ?>">
                    </div>

                    <div class="col-md-4">
                        <label>Teléfono</label>
                        <input type="text" name="phone" class="form-control"
                               value="<?php echo e(old('phone', $profile->phone)); ?>">
                    </div>

                    <div class="col-md-4">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control"
                               value="<?php echo e(old('email', $profile->email)); ?>">
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <label>Dirección</label>
                        <input type="text" name="address" class="form-control"
                               value="<?php echo e(old('address', $profile->address)); ?>">
                    </div>

                    <div class="col-md-6">
                        <label>Descripción</label>
                        <input type="text" name="description" class="form-control"
                               value="<?php echo e(old('description', $profile->description)); ?>">
                    </div>
                </div>

                <hr>

                
                <h5 class="mb-3">Información del Personal</h5>

                <div class="row">
                    <div class="col-md-6">
                        <label>Tipo de Personal</label>
                        <select name="staff_type" class="form-control" required>
                            <?php $__currentLoopData = $staffTypeLabels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value); ?>"
                                    <?php echo e(old('staff_type', $profile->staff_type) === $value ? 'selected' : ''); ?>>
                                    <?php echo e($label); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Especialización</label>
                        <input type="text" name="specialization" class="form-control"
                               value="<?php echo e(old('specialization', $profile->specialization)); ?>">
                    </div>
                </div>

                <hr>

                
                <h5 class="mb-3">Acceso al Sistema</h5>

                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="create_user"
                           name="create_user" value="1"
                           <?php echo e($profile->user ? 'checked' : ''); ?>>
                    <label class="form-check-label" for="create_user">
                        Este perfil tiene acceso al sistema
                    </label>
                </div>

                <div class="form-group">
                    <label>Rol en el Sistema</label>
                    <select name="role" id="role_select" class="form-control">
                        <option value="">-- Seleccione Rol --</option>
                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($role->name); ?>"
                                <?php echo e($profile->user && $profile->user->hasRole($role->name) ? 'selected' : ''); ?>>
                                <?php echo e($roleLabels[$role->name] ?? ucfirst(str_replace('_', ' ', $role->name))); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                
                <div id="permissions_box" class="card card-outline card-danger mt-3" style="display:none;">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fas fa-shield-alt"></i> Permisos del Administrador
                        </h5>
                    </div>

                    <div class="card-body">
                        <p class="text-muted">
                            Asigne solo los permisos necesarios.
                            <strong>Un uso incorrecto puede comprometer el sistema.</strong>
                        </p>

                        <div class="row">
                            <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                               name="permissions[]"
                                               value="<?php echo e($permission->name); ?>"
                                               <?php echo e($profile->user && $profile->user->hasPermissionTo($permission->name) ? 'checked' : ''); ?>>
                                        <label class="form-check-label">
                                            <?php echo e(ucfirst(str_replace('_', ' ', $permission->name))); ?>

                                        </label>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info mt-3">
                    <i class="fas fa-info-circle"></i>
                    Si no deseas cambiar la contraseña, deja los campos en blanco.
                </div>

                <div class="form-group">
                    <label>Nueva Contraseña</label>
                    <input type="password" name="password" class="form-control"
                           placeholder="Dejar vacío para mantener la actual">
                </div>

                <div class="form-group">
                    <label>Confirmar Nueva Contraseña</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>

            </div>

            <div class="card-footer">
                <a href="<?php echo e(route('profiles.index')); ?>" class="btn btn-secondary">
                    Cancelar
                </a>
                <button type="submit" class="btn btn-warning">
                    Actualizar Perfil
                </button>
            </div>

        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const roleSelect = document.getElementById('role_select');
    const permissionsBox = document.getElementById('permissions_box');

    function togglePermissions() {
        if (roleSelect.value === 'admin') {
            permissionsBox.style.display = 'block';
        } else {
            permissionsBox.style.display = 'none';
            permissionsBox.querySelectorAll('input[type=checkbox]').forEach(cb => cb.checked = false);
        }
    }

    roleSelect.addEventListener('change', togglePermissions);
    togglePermissions(); // al cargar
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\TitulacionHeavy-respaldo\resources\views/profiles/edit.blade.php ENDPATH**/ ?>