

<?php $__env->startSection('title', 'Historial de Pagos'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">

    <div class="card card-outline card-secondary">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-history"></i>
                Historial completo de pagos
            </h3>

            <div class="card-tools">
                <a href="<?php echo e(route('payments.index')); ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-arrow-left"></i> Pagos activos
                </a>
            </div>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Comprobante</th>
                        <th>Proforma</th>
                        <th>Monto</th>
                        <th>Método</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="<?php echo e($payment->status === 'cancelled' ? 'table-danger' : ''); ?>">

                            <td><?php echo e($payment->id); ?></td>

                            <td>
                                <strong><?php echo e($payment->receipt_number); ?></strong>
                            </td>

                            <td>
                                #<?php echo e($payment->proforma_id); ?>

                            </td>

                            <td>
                                $<?php echo e(number_format($payment->amount, 2)); ?>

                            </td>

                            <td>
                                <?php echo e(ucfirst($payment->payment_method)); ?>

                            </td>

                            <td>
                                <?php if($payment->status === 'valid'): ?>
                                    <span class="badge badge-success">
                                        VÁLIDO
                                    </span>
                                <?php else: ?>
                                    <span class="badge badge-danger">
                                        ANULADO
                                    </span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php echo e($payment->paid_at?->format('Y-m-d H:i') ?? '—'); ?>

                            </td>

                            <td>
                                <a href="<?php echo e(route('payments.show', $payment)); ?>"
                                   class="btn btn-info btn-sm"
                                   title="Ver comprobante">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <?php if($payment->status === 'cancelled'): ?>
                                    <span class="text-muted ml-2">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                <?php endif; ?>
                            </td>

                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                No existen pagos registrados
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="card-footer clearfix">
            <?php echo e($payments->links()); ?>

        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\TitulacionHeavy-respaldo\resources\views/payments/history.blade.php ENDPATH**/ ?>