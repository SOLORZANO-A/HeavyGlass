<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Estado del Vehículo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

    <div class="container mt-5">

        <h3 class="mb-4 text-center">
            Historial del vehículo: <strong><?php echo e($search); ?></strong>
        </h3>

        <?php $__currentLoopData = $proformas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proforma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $paid = $proforma->payments->where('status', 'valid')->sum('amount');

                $balance = $proforma->total - $paid;
            ?>

            <div class="card mb-4 shadow-sm">

                <div class="card-header bg-primary text-white">
                    Proforma #<?php echo e($proforma->id); ?> •
                    <?php echo e($proforma->created_at->format('d/m/Y')); ?>

                </div>

                <div class="card-body">

                    
                    <p><strong>Cliente:</strong> <?php echo e($proforma->client_name); ?></p>
                    <p><strong>Vehículo:</strong>
                        <?php echo e($proforma->vehicle_brand); ?>

                        <?php echo e($proforma->vehicle_model); ?>

                        (<?php echo e($proforma->vehicle_plate); ?>)
                    </p>

                    <p><strong>Técnico encargado:</strong><br>
                        <?php if($proforma->workOrder && $proforma->workOrder->technicians->isNotEmpty()): ?>
                            <?php $__currentLoopData = $proforma->workOrder->technicians; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $technician): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="badge bg-info text-dark me-1">
                                    <?php echo e($technician->fullName()); ?>

                                    <?php if($technician->specialization): ?>
                                        (<?php echo e($technician->specialization); ?>)
                                    <?php endif; ?>
                                </span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <span class="text-muted">Pendiente de asignación</span>
                        <?php endif; ?>
                    </p>





                    <p><strong>Observaciones / Estado:</strong><br>
                        <?php if($proforma->workOrder && $proforma->workOrder->description): ?>
                            <?php echo e($proforma->workOrder->description); ?>

                        <?php else: ?>
                            <span class="text-muted">Sin observaciones registradas</span>
                        <?php endif; ?>
                    </p>


                    
                    <hr>
                    <h6>Detalle de trabajos</h6>

                    <table class="table table-sm table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Descripción</th>
                                <th class="text-center">Cant.</th>
                                <th class="text-end">Precio Unit.</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $proforma->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($detail->item_description); ?></td>
                                    <td class="text-center"><?php echo e($detail->quantity); ?></td>
                                    <td class="text-end">
                                        $<?php echo e(number_format($detail->unit_price, 2)); ?>

                                    </td>
                                    <td class="text-end">
                                        $<?php echo e(number_format($detail->line_total, 2)); ?>

                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>

                    
                    <p class="mt-2">
                        <strong>Total:</strong>
                        $<?php echo e(number_format($proforma->total, 2)); ?>

                    </p>

                    
                    <p>
                        <strong>Estado de pago:</strong>
                        <?php if($balance <= 0): ?>
                            <span class="badge bg-success">
                                Pagado ($<?php echo e(number_format($paid, 2)); ?>)
                            </span>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark">
                                Abonado $<?php echo e(number_format($paid, 2)); ?>

                                (Falta $<?php echo e(number_format($balance, 2)); ?>)
                            </span>
                        <?php endif; ?>
                    </p>

                    
                    <p>
                        <strong>Aprobación del cliente:</strong>
                        <?php if($proforma->isSigned()): ?>
                            <span class="badge bg-success">Aceptada</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Pendiente</span>
                        <?php endif; ?>
                    </p>

                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <div class="text-center mt-4 text-muted small">
            HEAVY GLASS • Consulta pública informativa
        </div>

    </div>

</body>

</html>
<?php /**PATH C:\laragon\www\TitulacionHeavy-respaldo\resources\views/public/result.blade.php ENDPATH**/ ?>