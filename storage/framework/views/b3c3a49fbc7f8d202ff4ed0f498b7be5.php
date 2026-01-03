

<?php $__env->startSection('title', 'Registrar Pago'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Registrar Pago</h3>
            </div>

            <form action="<?php echo e(route('payments.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="card-body">

                    
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    
                    <div class="form-group">
                        <label>Proforma</label>
                        <select name="proforma_id" id="proforma_select" class="form-control" required>

                            <option value="">-- Seleccione Proforma --</option>

                            <?php $__currentLoopData = $proformas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proforma): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $paid = $proforma->payments->where('status', 'valid')->sum('amount');

                                    $balance = round($proforma->total - $paid, 2);

                                    $isSigned = $proforma->signature_status === 'signed';
                                ?>

                                <option value="<?php echo e($proforma->id); ?>" data-total="<?php echo e($proforma->total); ?>"
                                    data-paid="<?php echo e($paid); ?>" data-balance="<?php echo e($balance); ?>"
                                    <?php echo e(!$isSigned ? 'disabled' : ''); ?>>

                                    #<?php echo e($proforma->id); ?> — <?php echo e($proforma->vehicle_plate); ?>


                                    <?php if(!$isSigned): ?>
                                        ❌ (No firmada)
                                    <?php elseif($balance <= 0): ?>
                                        ✅ (Pagada)
                                    <?php else: ?>
                                        💰 (Saldo: $<?php echo e(number_format($balance, 2)); ?>)
                                    <?php endif; ?>
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>

                        <small class="form-text text-muted mt-1">
                            ⚠️ Solo se pueden registrar pagos para proformas <strong>firmadas por el cliente</strong>.
                        </small>

                    </div>

                    
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label>Total de la proforma</label>
                            <input type="text" id="proforma_total" class="form-control" readonly>
                        </div>

                        <div class="col-md-4">
                            <label>Total pagado</label>
                            <input type="text" id="proforma_paid" class="form-control" readonly>
                        </div>

                        <div class="col-md-4">
                            <label>Saldo pendiente</label>
                            <input type="text" id="proforma_balance" class="form-control" readonly>
                        </div>
                    </div>

                    
                    <div class="form-group mt-3">
                        <label>Valor a cancelar</label>
                        <input type="number" step="0.01" name="amount" id="amount_input" class="form-control"
                            placeholder="Seleccione una proforma" required>
                        <div class="invalid-feedback">
                            El monto no puede superar el saldo pendiente.
                        </div>
                    </div>

                    
                    <div class="form-group">
                        <label>Método de pago</label>
                        <select name="payment_method" class="form-control" required>
                            <option value="">-- Seleccione un método --</option>
                            <option value="cash">Efectivo</option>
                            <option value="transfer">Transferencia</option>
                            <option value="card">Tarjeta</option>
                        </select>
                    </div>

                    
                    <div class="form-group">
                        <label>Descripción / Referencia</label>
                        <textarea name="description" class="form-control" rows="3"
                            placeholder="Número de transacción, comprobante o notas"></textarea>
                    </div>

                </div>

                <div class="card-footer">
                    <a href="<?php echo e(route('payments.index')); ?>" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar Pago</button>
                </div>

            </form>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const select = document.getElementById('proforma_select');
            const totalInput = document.getElementById('proforma_total');
            const paidInput = document.getElementById('proforma_paid');
            const balanceInput = document.getElementById('proforma_balance');
            const amountInput = document.getElementById('amount_input');

            let currentBalance = 0;

            select.addEventListener('change', function() {
                const option = this.options[this.selectedIndex];
                if (!option.value) return;

                const total = parseFloat(option.dataset.total);
                const paid = parseFloat(option.dataset.paid);
                const balance = parseFloat(option.dataset.balance);

                currentBalance = balance;

                totalInput.value = '$' + total.toFixed(2);
                paidInput.value = '$' + paid.toFixed(2);
                balanceInput.value = '$' + balance.toFixed(2);

                amountInput.value = balance.toFixed(2);
                amountInput.classList.remove('is-invalid');
            });

            amountInput.addEventListener('input', function() {
                const entered = parseFloat(this.value) || 0;

                if (entered > currentBalance) {
                    this.classList.add('is-invalid');
                } else {
                    this.classList.remove('is-invalid');
                }
            });

        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\TitulacionHeavy-respaldo\resources\views/payments/create.blade.php ENDPATH**/ ?>