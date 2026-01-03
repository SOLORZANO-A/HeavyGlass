<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Proformas</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        .range {
            text-align: center;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 6px;
        }

        th {
            background: #f0f0f0;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>

    <h2>Reporte de Proformas e Ingresos</h2>

    <div class="range">
        Desde <strong><?php echo e($from); ?></strong> hasta <strong><?php echo e($to); ?></strong>
    </div>

    <table style="margin-bottom:15px">
        <tr>
            <th>Total Proformas</th>
            <td><?php echo e($totalProformas); ?></td>
            <th>Firmadas</th>
            <td><?php echo e($firmadas); ?></td>
            <th>No Firmadas</th>
            <td><?php echo e($noFirmadas); ?></td>
            <th>Ingresos</th>
            <td>$<?php echo e(number_format($ingresos, 2)); ?></td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Cliente</th>
                <th>Vehículo</th>
                <th>Total</th>
                <th>Fecha</th>
                <th>Pago</th>
                <th>Firma</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $proformas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proforma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="text-center"><?php echo e($proforma->id); ?></td>
                    <td><?php echo e($proforma->client_name); ?></td>
                    <td>
                        <?php echo e($proforma->vehicle_brand); ?>

                        <?php echo e($proforma->vehicle_model); ?>

                        (<?php echo e($proforma->vehicle_plate); ?>)
                    </td>
                    <?php
                        $pagado = $proforma->payments->where('status', 'valid')->sum('amount');

                        $pendiente = $proforma->total - $pagado;
                    ?>

                    <td class="text-right">
                        <?php if($proforma->status === 'paid'): ?>
                            $<?php echo e(number_format($pagado, 2)); ?>

                        <?php elseif($proforma->status === 'partial'): ?>
                            $<?php echo e(number_format($pagado, 2)); ?>

                            <br>
                            <small>(faltan $<?php echo e(number_format($pendiente, 2)); ?>)</small>
                        <?php else: ?>
                            $0.00
                            <br>
                            <small>(faltan $<?php echo e(number_format($proforma->total, 2)); ?>)</small>
                        <?php endif; ?>
                    </td>

                    <td class="text-center">
                        <?php echo e($proforma->created_at->format('Y-m-d')); ?>

                    </td>
                    <td class="text-center">
                        <?php echo e(ucfirst($proforma->status)); ?>

                    </td>
                    <td class="text-center">
                        <?php echo e($proforma->signature_status === 'signed' ? 'Sí' : 'No'); ?>

                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

</body>

</html>
<?php /**PATH C:\laragon\www\TitulacionHeavy-respaldo\resources\views/reports/proformas_pdf.blade.php ENDPATH**/ ?>