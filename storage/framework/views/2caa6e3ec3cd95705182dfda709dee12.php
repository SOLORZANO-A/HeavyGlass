<?php $__env->startSection('title', 'Pagos'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">

        <div class="card shadow-sm">

            
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h3 class="card-title mb-0">
                    <i class="fas fa-money-bill-wave mr-1"></i> Pagos
                </h3>

                <div class="d-flex gap-2">
                    <a href="<?php echo e(route('payments.create')); ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Registrar Pago
                    </a>

                    <?php if (\Illuminate\Support\Facades\Blade::check('role', 'admin')): ?>
                        <a href="<?php echo e(route('payments.history')); ?>" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-history"></i> Historial de Pagos
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="card-body border-bottom">

                <div class="row mb-3">
                    <div class="col-md-5 mb-2">
                        <input type="text" id="searchInput" class="form-control"
                            placeholder="🔍 Buscar por comprobante, cliente, vehículo...">
                    </div>

                    <div class="col-md-7 text-md-right">
                        <a href="<?php echo e(route('payments.export.pdf')); ?>" class="btn btn-danger btn-sm">
                            <i class="fas fa-file-pdf"></i> PDF
                        </a>

                        <a href="<?php echo e(route('payments.export.csv')); ?>" class="btn btn-success btn-sm ml-1">
                            <i class="fas fa-file-excel"></i> Excel
                        </a>
                    </div>
                </div>

                
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle" id="FrmPagos">
                        <thead class="thead-light text-center">
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Vehículo</th>
                                <th>Proforma</th>
                                <th>Monto</th>
                                <th>Método</th>
                                <th>Cajera/o</th>
                                <th>Fecha</th>
                                <th width="180">Opciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="text-center"><?php echo e($payment->id); ?></td>
                                    <td><?php echo e($payment->proforma->client_name ?? '—'); ?></td>

                                    <td>
                                        <?php echo e($payment->proforma->vehicle_brand); ?>

                                        <?php echo e($payment->proforma->vehicle_model); ?>

                                        (<?php echo e($payment->proforma->vehicle_plate); ?>)
                                    </td>


                                    <td class="text-center">
                                        <span class="badge badge-info">
                                            #<?php echo e($payment->proforma->id); ?>

                                        </span>
                                    </td>

                                    <td class="text-right font-weight-bold text-success">
                                        $<?php echo e(number_format($payment->amount, 2)); ?>

                                    </td>

                                    <?php
                                        $methodLabels = [
                                            'cash' => 'Efectivo',
                                            'transfer' => 'Transferencia',
                                            'card' => 'Tarjeta',
                                        ];
                                    ?>

                                    <td class="text-center">
                                        <span class="badge badge-secondary">
                                            <?php echo e($methodLabels[$payment->payment_method] ?? '—'); ?>

                                        </span>
                                    </td>

                                    <td><?php echo e($payment->cashier?->fullName() ?? '—'); ?></td>

                                    <td class="text-center">
                                        <?php echo e($payment->paid_at?->format('Y-m-d') ?? '—'); ?>

                                    </td>

                                    <td class="text-center">

                                        <a href="<?php echo e(route('payments.show', $payment)); ?>" class="btn btn-info btn-sm"
                                            title="Ver">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <a href="<?php echo e(route('payments.edit', $payment)); ?>" class="btn btn-warning btn-sm"
                                            title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage payments')): ?>
                                            <form action="<?php echo e(route('payments.cancel', $payment)); ?>" method="POST"
                                                class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>

                                                <button type="button" class="btn btn-warning btn-sm" data-confirm
                                                    data-title="¿Anular pago?" data-text="El pago será marcado como cancelado"
                                                    data-confirm="Sí, anular">
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>

                                        
                                        <?php if (\Illuminate\Support\Facades\Blade::check('role', 'admin')): ?>
                                            <form action="<?php echo e(route('payments.destroy', $payment)); ?>" method="POST"
                                                class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>

                                                <button type="button" class="btn btn-danger btn-sm" data-confirm
                                                    data-title="¿Eliminar pago?"
                                                    data-text="El pago será eliminado definitivamente"
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
                                        No hay pagos registrados
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            
            <div class="card-footer clearfix">
                <?php echo e($payments->links()); ?>

            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const value = this.value.toLowerCase();
            const rows = document.querySelectorAll('#FrmPagos tbody tr');

            rows.forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(value) ?
                    '' :
                    'none';
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\HeavyGlass-main\resources\views/payments/index.blade.php ENDPATH**/ ?>