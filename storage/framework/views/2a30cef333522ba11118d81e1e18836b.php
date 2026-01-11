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

                    
                    <select name="proforma_id" id="proforma_select"
                        class="form-control select2 <?php $__errorArgs = ['proforma_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>

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
        $(document).ready(function() {

            const totalInput = $('#proforma_total');
            const paidInput = $('#proforma_paid');
            const balanceInput = $('#proforma_balance');
            const amountInput = $('#amount_input');

            let currentBalance = 0;

            // Inicializar Select2
            const proformaSelect = $('#proforma_select').select2({
                placeholder: '-- Seleccione Proforma --',
                allowClear: true,
                width: '100%',
                minimumResultsForSearch: 0
            });

            // ✅ CUANDO SE SELECCIONA UNA PROFORMA
            proformaSelect.on('select2:select', function(e) {

                const option = e.params.data.element;

                const total = parseFloat(option.dataset.total);
                const paid = parseFloat(option.dataset.paid);
                const balance = parseFloat(option.dataset.balance);

                currentBalance = balance;

                totalInput.val('$' + total.toFixed(2));
                paidInput.val('$' + paid.toFixed(2));
                balanceInput.val('$' + balance.toFixed(2));

                amountInput.val(balance.toFixed(2));
                amountInput.removeClass('is-invalid');
            });

            // ✅ CUANDO SE LIMPIA EL SELECT (X)
            proformaSelect.on('select2:clear', function() {

                totalInput.val('');
                paidInput.val('');
                balanceInput.val('');
                amountInput.val('');
                currentBalance = 0;
            });

            // ✅ VALIDACIÓN DEL MONTO
            amountInput.on('input', function() {
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
<?php $__env->startPush('styles'); ?>
    <style>
        /* ===== FIX SELECT2 + ADMINLTE ===== */

        .select2-container .select2-selection--single {
            height: 38px !important;
            /* Altura estándar Bootstrap */
            padding: 4px 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            display: flex;
            align-items: center;
        }

        .select2-selection__rendered {
            line-height: normal !important;
            padding-left: 0 !important;
            color: #495057;
        }

        .select2-selection__arrow {
            height: 36px !important;
            top: 1px !important;
        }

        /* Focus */
        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
        }

        /* Disabled */
        .select2-container--default .select2-results__option[aria-disabled=true] {
            color: #dc3545;
            font-weight: 500;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\HeavyGlass-main\resources\views/payments/create.blade.php ENDPATH**/ ?>