

<?php $__env->startSection('title', 'Comprobante de Pago'); ?>

<?php
    $proforma = $payment->proforma;

    $total = $proforma?->total ?? 0;
    $paid = $proforma?->payments->sum('amount') ?? 0;
    $balance = round($total - $paid, 2);
?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">

        <div class="card card-info">

            
            <div class="card-header">
                <h3 class="card-title">
                    🧾 Comprobante de Pago
                </h3>

                <div class="card-tools">
                    <a href="<?php echo e(route('payments.index')); ?>" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
            </div>

            
            <div class="card-body">

                <table class="table table-bordered">

                    <tr>
                        <th width="250">N° de Comprobante</th>
                        <td><strong><?php echo e($payment->receipt_number ?? '—'); ?></strong></td>
                    </tr>

                    <tr>
                        <th>Fecha de emisión</th>
                        <td><?php echo e(optional($payment->issued_at)->format('Y-m-d H:i') ?? '—'); ?></td>
                    </tr>

                    <tr>
                        <th>Proforma</th>
                        <td>
                            <?php if($proforma): ?>
                                #<?php echo e($proforma->id); ?>

                            <?php else: ?>
                                —
                            <?php endif; ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Cliente</th>
                        <td><?php echo e($payment->proforma->client_name ?? '—'); ?></td>
                    </tr>


                    <tr>
                        <th>Vehículo</th>
                        <td>
                            <?php echo e($proforma?->vehicle_brand ?? ''); ?>

                            <?php echo e($proforma?->vehicle_model ?? ''); ?>

                            <small class="text-muted">
                                (<?php echo e($proforma?->vehicle_plate ?? '—'); ?>)
                            </small>
                        </td>
                    </tr>

                    <tr>
                        <th>Total de la proforma</th>
                        <td><strong>$<?php echo e(number_format($total, 2)); ?></strong></td>
                    </tr>

                    <tr>
                        <th>Total pagado</th>
                        <td class="text-success">
                            $<?php echo e(number_format($totalPaid, 2)); ?>

                        </td>
                    </tr>


                    <tr>
                        <th>Saldo pendiente</th>
                        <td>
                            <?php if($balance > 0): ?>
                                <span class="badge badge-warning">
                                    $<?php echo e(number_format($balance, 2)); ?>

                                </span>
                            <?php else: ?>
                                <span class="badge badge-success">
                                    PAGADO
                                </span>
                            <?php endif; ?>
                        </td>
                    </tr>



                    <tr>
                        <th>Monto de este pago</th>
                        <td>
                            <strong class="text-success">
                                $<?php echo e(number_format($payment->amount, 2)); ?>

                            </strong>
                        </td>
                    </tr>

                    <tr>
                        <th>Método de pago</th>
                        <td>
                            <?php echo e([
                                'cash' => 'Efectivo',
                                'transfer' => 'Transferencia',
                                'card' => 'Tarjeta',
                            ][$payment->payment_method] ?? '—'); ?>

                        </td>
                    </tr>

                    <tr>
                        <th>Referencia / Observación</th>
                        <td><?php echo e($payment->description ?? '—'); ?></td>
                    </tr>

                    <tr>
                        <th>Cajera</th>
                        <td>
                            <?php echo e($payment->cashier?->fullName() ?? '—'); ?>

                        </td>
                    </tr>

                    <tr>
                        <th>Estado de la proforma</th>
                        <td>
                            <?php
                                $statusLabels = [
                                    'pending' => 'Pendiente',
                                    'partial' => 'Pago parcial',
                                    'paid' => 'Pagada',
                                ];
                            ?>

                            <span class="badge badge-info">
                                <?php echo e($statusLabels[$proforma?->status] ?? '—'); ?>

                            </span>
                        </td>
                    </tr>

                </table>

            </div>

            
            <div class="card-footer text-right">
                <a href="<?php echo e(route('payments.index')); ?>" class="btn btn-secondary">
                    Volver
                </a>

                
                <button onclick="window.print()" class="btn btn-primary">
                    <i class="fas fa-print"></i> Imprimir
                </button>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['manage payments', 'admin'])): ?>
                    <a href="<?php echo e(route('payments.receipt', $payment)); ?>" target="_blank" class="btn btn-danger">
                        <i class="fas fa-file-pdf"></i>
                        Ver comprobante PDF
                    </a>
                <?php endif; ?>




            </div>

        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\TitulacionHeavy-respaldo\resources\views/payments/show.blade.php ENDPATH**/ ?>