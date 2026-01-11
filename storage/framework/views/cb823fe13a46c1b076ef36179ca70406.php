<?php $__env->startSection('title', 'Nuevo Perfil'); ?>

<?php $__env->startSection('content'); ?>

<?php
    $permissionLabels = [
        'manage profiles' => 'Gestionar perfiles',
        'manage clients' => 'Gestionar clientes',
        'manage vehicles' => 'Gestionar vehículos',
        'manage intake sheets' => 'Gestionar hojas de ingreso',
        'manage work orders' => 'Gestionar órdenes de trabajo',
        'manage proformas' => 'Gestionar proformas',
        'manage payments' => 'Gestionar pagos',
    ];

    $roleLabels = [
        'admin' => 'Administrador',
        'advisor' => 'Asesor',
        'cashier' => 'Cajero/a',
        'workshop_boss' => 'Jefe de Taller',
        'workshop_manager' => 'Jefe de Taller'
    ];
?>

<div class="container-fluid">

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Crear Nuevo Perfil</h3>
        </div>

        <form action="<?php echo e(route('profiles.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <div class="card-body">

                
                <h5 class="mb-3">Información Personal</h5>

                <div class="row">
                    <div class="col-md-6">
                        <label>Primer nombre</label>
                        <input type="text" name="first_name" class="form-control" value="<?php echo e(old('first_name')); ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label>Apellido</label>
                        <input type="text" name="last_name" class="form-control" value="<?php echo e(old('last_name')); ?>" required>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-4">
                        <label>Cédula de Identidad</label>
                        <input type="text" name="document" class="form-control" value="<?php echo e(old('document')); ?>">
                    </div>

                    <div class="col-md-4">
                        <label>Teléfono</label>
                        <input type="text" name="phone" class="form-control" value="<?php echo e(old('phone')); ?>">
                    </div>

                    <div class="col-md-4">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="<?php echo e(old('email')); ?>">
                        <small class="text-muted">Requerido para el acceso al sistema</small>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <label>Dirección</label>
                        <input type="text" name="address" class="form-control" value="<?php echo e(old('address')); ?>">
                    </div>

                    <div class="col-md-6">
                        <label>Descripción</label>
                        <input type="text" name="description" class="form-control" value="<?php echo e(old('description')); ?>">
                    </div>
                </div>

                <hr>

                
                <h5 class="mb-3">Información del Personal</h5>

                <div class="row">
                    <div class="col-md-6">
                        <label>Tipo de Personal</label>
                        <select name="staff_type" class="form-control" required>
                            <option value="">-- Seleccione --</option>
                            <option value="technician">Técnico</option>
                            <option value="advisor">Asesor</option>
                            <option value="cashier">Cajero/a</option>
                            <option value="workshop_manager">Jefe de Taller</option>
                            <option value="admin">Administrador</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Especialización</label>
                        <input type="text" name="specialization" class="form-control">
                    </div>
                </div>

                <hr>

                
                <h5 class="mb-3">Acceso al Sistema</h5>

                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="create_user" name="create_user" value="1">
                    <label class="form-check-label" for="create_user">
                        Este perfil tiene acceso al sistema
                    </label>
                </div>

                <div class="form-group">
                    <label>Rol en el Sistema</label>
                    <select name="role" id="role_select" class="form-control">
                        <option value="">-- Seleccione Rol --</option>
                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($role->name); ?>">
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

                        <?php $__currentLoopData = $permissionLabels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                       name="permissions[]"
                                       value="<?php echo e($permission); ?>"
                                       id="perm_<?php echo e(Str::slug($permission)); ?>">
                                <label class="form-check-label" for="perm_<?php echo e(Str::slug($permission)); ?>">
                                    <?php echo e($label); ?>

                                </label>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <hr>

                <div class="form-group">
                    <label>Contraseña</label>
                    <input type="password" name="password" class="form-control" placeholder="Mínimo 6 caracteres">
                </div>

                <div class="form-group">
                    <label>Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>

            </div>

            <div class="card-footer">
                <a href="<?php echo e(route('profiles.index')); ?>" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Crear Perfil</button>
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
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\HeavyGlass-main\resources\views/profiles/create.blade.php ENDPATH**/ ?>