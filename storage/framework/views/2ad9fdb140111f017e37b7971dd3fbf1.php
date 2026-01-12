<?php $__env->startSection('title', 'Detalle de Proforma'); ?>

<?php $__env->startSection('content'); ?>
    <?php
        use Illuminate\Support\Facades\Storage;
    ?>

    <div class="container-fluid">

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">
                    Proforma #<?php echo e($proforma->id); ?>

                </h3>

                <div class="card-tools">
                    <a href="<?php echo e(route('proformas.index')); ?>" class="btn btn-secondary btn-sm">
                        Volver
                    </a>
                </div>
            </div>

            <div class="card-body">

                
                <table class="table table-bordered mb-4">
                    <tr>
                        <th width="250">Orden de trabajo</th>
                        <td>
                            <?php if($proforma->workOrder): ?>
                                #<?php echo e($proforma->workOrder->id); ?> —
                                <?php echo e($proforma->vehicle_plate); ?>

                            <?php else: ?>
                                <span class="text-muted">No asignada</span>
                            <?php endif; ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Cliente</th>
                        <td><?php echo e($proforma->client_name); ?></td>
                    </tr>

                    <tr>
                        <th>Documento</th>
                        <td><?php echo e($proforma->client_document); ?></td>
                    </tr>

                    <tr>
                        <th>Teléfono</th>
                        <td><?php echo e($proforma->client_phone); ?></td>
                    </tr>

                    <tr>
                        <th>Email</th>
                        <td><?php echo e($proforma->client_email); ?></td>
                    </tr>

                    <tr>
                        <th>Vehículo</th>
                        <td>
                            <?php echo e($proforma->vehicle_brand); ?>

                            <?php echo e($proforma->vehicle_model); ?>

                            (<?php echo e($proforma->vehicle_plate); ?>)
                        </td>
                    </tr>

                    <tr>
                        <th>Estado de la proforma</th>
                        <td>
                            <span class="badge badge-<?php echo e($proforma->status === 'paid' ? 'success' : 'warning'); ?>">
                                <?php echo e(ucfirst($proforma->status)); ?>

                            </span>
                        </td>
                    </tr>

                    <tr>
                        <th>Firma del cliente</th>
                        <td>
                            <?php if($proforma->isSigned()): ?>
                                <span class="badge badge-success">Firmada</span>
                            <?php else: ?>
                                <span class="badge badge-danger">Pendiente</span>
                            <?php endif; ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Observaciones</th>
                        <td><?php echo e($proforma->observations ?? '—'); ?></td>
                    </tr>
                </table>

                
                
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-dark text-white d-flex align-items-center">
                        <i class="fas fa-box mr-2"></i>
                        <strong>Repuestos / Detalles</strong>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-sm table-hover mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Descripción</th>
                                    <th class="text-center">Precio Unit.</th>
                                    <th class="text-center">Cant.</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $proforma->details->where('type', 'part'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($detail->item_description); ?></td>
                                        <td class="text-center">$<?php echo e(number_format($detail->unit_price, 2)); ?></td>
                                        <td class="text-center"><?php echo e($detail->quantity); ?></td>
                                        <td class="text-end font-weight-bold">
                                            $<?php echo e(number_format($detail->line_total, 2)); ?>

                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>

                    </div>
                </div>

                
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-dark text-white d-flex align-items-center">
                        <i class="fas fa-tools mr-2"></i>
                        <strong>Mano de Obra</strong>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-sm table-hover mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Descripción</th>
                                    <th class="text-center">Precio</th>
                                    <th class="text-center">Cant.</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $proforma->details->where('type', 'labor'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($detail->item_description); ?></td>
                                        <td class="text-center">$<?php echo e(number_format($detail->unit_price, 2)); ?></td>
                                        <td class="text-center"><?php echo e($detail->quantity); ?></td>
                                        <td class="text-end font-weight-bold">
                                            $<?php echo e(number_format($detail->line_total, 2)); ?>

                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>

                    </div>
                </div>

                
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-dark text-white d-flex align-items-center">
                        <i class="fas fa-dollar-sign mr-2"></i>
                        <strong>Totales</strong>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <th class="text-end text-muted">Subtotal</th>
                                    <td class="text-end">$<?php echo e(number_format($proforma->subtotal, 2)); ?></td>
                                </tr>
                                <tr>
                                    <th class="text-end text-muted">IVA (15%)</th>
                                    <td class="text-end">$<?php echo e(number_format($proforma->tax, 2)); ?></td>
                                </tr>
                                <tr class="bg-success text-white">
                                    <th class="text-end h5 mb-0">TOTAL</th>
                                    <td class="text-end h5 mb-0">
                                        $<?php echo e(number_format($proforma->total, 2)); ?>

                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>

                
                
                <hr>
                <h5>Firma del Cliente</h5>

                <?php if($proforma->isSigned()): ?>
                    <div class="mt-2">
                        <img src="<?php echo e(Storage::url($proforma->signature_path)); ?>?v=<?php echo e($proforma->updated_at->timestamp); ?>"
                            alt="Firma del cliente" class="img-fluid"
                            style="
        max-width: 400px;
        background: #fff;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    ">

                    </div>
                <?php else: ?>
                    <form id="signature-form" action="<?php echo e(route('proformas.sign', $proforma)); ?>" method="POST">
                        <?php echo csrf_field(); ?>

                        <canvas id="signature-pad"
                            style="border:1px solid #ccc; width:100%; height:200px; background:#fff;">
                        </canvas>

                        <input type="hidden" name="signature" id="signature">

                        <div class="mt-2">
                            <button type="button" id="clear-signature" class="btn btn-secondary btn-sm">
                                Limpiar firma
                            </button>

                            <button type="button" class="btn btn-primary btn-sm" id="btn-save-signature">
                                Guardar firma
                            </button>


                        </div>
                    </form>
                <?php endif; ?>


            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const canvas = document.getElementById('signature-pad');

        function isCanvasEmpty(canvas) {
            const blank = document.createElement('canvas');
            blank.width = canvas.width;
            blank.height = canvas.height;
            return canvas.toDataURL() === blank.toDataURL();
        }

        if (canvas) {
            const ctx = canvas.getContext('2d');

            canvas.width = canvas.offsetWidth;
            canvas.height = canvas.offsetHeight;

            let drawing = false;

            const getPos = (e) => {
                const rect = canvas.getBoundingClientRect();
                return {
                    x: (e.touches ? e.touches[0].clientX : e.clientX) - rect.left,
                    y: (e.touches ? e.touches[0].clientY : e.clientY) - rect.top
                };
            };

            const start = (e) => {
                drawing = true;
                const pos = getPos(e);
                ctx.beginPath();
                ctx.moveTo(pos.x, pos.y);
            };

            const draw = (e) => {
                if (!drawing) return;
                const pos = getPos(e);
                ctx.lineWidth = 2.5;
                ctx.lineCap = 'round';
                ctx.strokeStyle = '#000';
                ctx.lineTo(pos.x, pos.y);
                ctx.stroke();
            };

            const end = () => {
                drawing = false;
                ctx.beginPath();
            };

            // Mouse
            canvas.addEventListener('mousedown', start);
            canvas.addEventListener('mousemove', draw);
            canvas.addEventListener('mouseup', end);

            // Touch
            canvas.addEventListener('touchstart', start);
            canvas.addEventListener('touchmove', draw);
            canvas.addEventListener('touchend', end);

            document.getElementById('clear-signature').onclick = () => {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
            };

            // ✅ BOTÓN GUARDAR FIRMA CON VALIDACIÓN REAL
            document.getElementById('btn-save-signature').onclick = () => {

                if (isCanvasEmpty(canvas)) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Firma requerida',
                        text: 'El cliente debe firmar antes de continuar'
                    });
                    return;
                }

                Swal.fire({
                    title: '¿Confirmar firma?',
                    text: 'El cliente acepta la proforma y los valores indicados',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, firmar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('signature').value =
                            canvas.toDataURL('image/png');

                        document.getElementById('signature-form').submit();
                    }
                });
            };
        }
    </script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\HeavyGlass-main\resources\views/proformas/show.blade.php ENDPATH**/ ?>