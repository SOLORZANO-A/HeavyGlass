

<?php $__env->startSection('title', 'Client Details'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Información Cliente</h3>

                <div class="card-tools">
                    <a href="<?php echo e(route('clients.edit', $client)); ?>" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Editar
                    </a>

                    <a href="<?php echo e(route('clients.index')); ?>" class="btn btn-secondary btn-sm">
                        Atras
                    </a>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="200">Nombre Completo</th>
                        <td><?php echo e($client->fullName()); ?></td>
                    </tr>
                    <tr>
                        <th>Documento</th>
                        <td><?php echo e($client->document); ?></td>
                    </tr>
                    <tr>
                        <th>Copia de cédula</th>
                        <td>
                            <?php if($client->id_copy_path): ?>
                                <a href="<?php echo e(asset('storage/' . $client->id_copy_path)); ?>" target="_blank"
                                    class="btn btn-sm btn-info">
                                    Ver copia de cédula
                                </a>
                            <?php else: ?>
                                —
                            <?php endif; ?>
                        </td>
                    </tr>


                    <tr>
                        <th>Telefono</th>
                        <td><?php echo e($client->phone ?? '—'); ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?php echo e($client->email ?? '—'); ?></td>
                    </tr>
                    <tr>
                        <th>Dirreción</th>
                        <td><?php echo e($client->address ?? '—'); ?></td>
                    </tr>
                    <tr>
                        <th>Tipo Cliente</th>
                        <td><?php echo e(ucfirst($client->client_type)); ?></td>
                    </tr>
                    <tr>
                        <th>Descripcion</th>
                        <td><?php echo e($client->description ?? '—'); ?></td>
                    </tr>
                    <tr>
                        <th>Hora de creacion</th>
                        <td><?php echo e($client->created_at->format('Y-m-d H:i')); ?></td>
                    </tr>
                </table>
            </div>

            <div class="card-footer">
                <a href="<?php echo e(route('clients.index')); ?>" class="btn btn-secondary">
                    Regresar a la lista
                </a>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\TitulacionHeavy-respaldo\resources\views/clients/show.blade.php ENDPATH**/ ?>