

<?php $__env->startSection('title', 'Perfiles'); ?>

<?php $__env->startSection('content'); ?>

<?php
    // Traducciones visibles
    $staffTypeLabels = [
        'technician'        => 'Técnico',
        'advisor'           => 'Asesor',
        'cashier'           => 'Cajero/a',
        'workshop_boss'  => 'Jefe de Taller',
        'admin'             => 'Administrador',
    ];

    $roleLabels = [
        'admin'            => 'Administrador',
        'advisor'          => 'Asesor',
        'cashier'          => 'Cajero/a',
        'workshop_manager' => 'Jefe de Taller',
    ];
?>



<div class="container-fluid">

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Personal y Técnicos</h3>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage users')): ?>
                <div class="card-tools">
                    <a href="<?php echo e(route('profiles.create')); ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Nuevo perfil
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre completo</th>
                        <th>Tipo de personal</th>
                        <th>Especialización</th>
                        <th>Usuario del sistema</th>
                        <th>Rol en el sistema</th>
                        <th>Opciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $profiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $profile): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($profile->id); ?></td>

                            
                            <td><?php echo e($profile->fullName()); ?></td>

                            
                            <td>
                                <span class="badge badge-info">
                                    <?php echo e($staffTypeLabels[$profile->staff_type] ?? ucfirst($profile->staff_type)); ?>

                                </span>
                            </td>

                            
                            <td><?php echo e($profile->specialization ?? '—'); ?></td>

                            
                            <td>
                                <?php if($profile->user): ?>
                                    <span class="badge badge-success">Sí</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary">No</span>
                                <?php endif; ?>
                            </td>

                            
                            <td>
                                <?php if($profile->user && $profile->user->getRoleNames()->isNotEmpty()): ?>
                                    <?php
                                        $roleName = $profile->user->getRoleNames()->first();
                                    ?>
                                    <span class="badge badge-primary">
                                        <?php echo e($roleLabels[$roleName] ?? ucfirst(str_replace('_', ' ', $roleName))); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?>
                            </td>

                            
                            <td>
                                <a href="<?php echo e(route('profiles.show', $profile)); ?>"
                                   class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage users')): ?>
                                    <a href="<?php echo e(route('profiles.edit', $profile)); ?>"
                                       class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="<?php echo e(route('profiles.destroy', $profile)); ?>"
                                          method="POST"
                                          class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>

                                        <button type="button" class="btn btn-danger btn-sm" data-confirm
                                            data-title="¿Eliminar perfil?" data-text="El perfil se eliminara definitivamente"
                                            data-confirm="Sí, eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                No hay perfiles registrados
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="card-footer clearfix">
            <?php echo e($profiles->links()); ?>

        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\TitulacionHeavy-respaldo\resources\views/profiles/index.blade.php ENDPATH**/ ?>