<?php $__env->startSection('title', 'Clients'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-users"></i> Lista de Clientes
                </h3>
            </div>

            <div class="row mb-3 align-items-center">
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control"
                            placeholder="Buscar cliente por nombre, cédula o teléfono..." data-table-filter="clients-table">
                    </div>
                </div>

                <div class="col-md-4 text-end">
                    <a href="<?php echo e(route('clients.create')); ?>" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nuevo Cliente
                    </a>
                </div>
            </div>


            <div class="card-body table-responsive p-0">
                <table id="clients-table" class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre Completo</th>
                            <th>Cedula</th>
                            <th>Telefono</th>
                            <th>Tipo</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($client->id); ?></td>
                                <td><?php echo e($client->fullName()); ?></td>
                                <td><?php echo e($client->document); ?></td>
                                <td><?php echo e($client->phone ?? '—'); ?></td>
                                <td>
                                    <?php switch($client->client_type):
                                        case ('owner'): ?>
                                            Dueño
                                        <?php break; ?>

                                        <?php case ('third'): ?>
                                            Tercera persona
                                        <?php break; ?>
                                        <?php case ('insurance'): ?>
                                            Aseguradora
                                        <?php break; ?>
                                        <?php default: ?>
                                            —
                                    <?php endswitch; ?>
                                </td>

                                <td>
                                    <a href="<?php echo e(route('clients.show', $client)); ?>" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="<?php echo e(route('clients.edit', $client)); ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="<?php echo e(route('clients.destroy', $client)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>

                                        <button type="button" class="btn btn-danger btn-sm" data-confirm
                                            data-title="¿Eliminar cliente?"
                                            data-text="El cliente será eliminado definitivamente"
                                            data-confirm="Sí, eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>


                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        No se encontraron CLientes
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="card-footer clearfix">
                    <?php echo e($clients->links()); ?>

                </div>
            </div>

        </div>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\HeavyGlass-main\resources\views/clients/index.blade.php ENDPATH**/ ?>