

<?php $__env->startSection('title', 'Edit Proforma'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">

    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">Editar Proforma #<?php echo e($proforma->id); ?></h3>
        </div>

        <form action="<?php echo e(route('proformas.update', $proforma)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="card-body">

                
                <div class="form-group">
                    <label>Orden de trabajo</label>
                    <input type="text"
                           class="form-control"
                           readonly
                           value="
                           <?php if($proforma->workOrder): ?>
                               #<?php echo e($proforma->workOrder->id); ?> - <?php echo e($proforma->workOrder->intakeSheet->vehicle->plate); ?>

                           <?php else: ?>
                               No work order assigned
                           <?php endif; ?>
                           ">
                </div>

                
                <h5>Proforma Detalles</h5>

                <div id="details-wrapper">
                    <?php $__currentLoopData = $proforma->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <input type="text"
                                       name="details[<?php echo e($i); ?>][description]"
                                       class="form-control"
                                       value="<?php echo e($detail->item_description); ?>">
                            </div>

                            <div class="col-md-3">
                                <input type="number"
                                       step="0.01"
                                       name="details[<?php echo e($i); ?>][price]"
                                       class="form-control"
                                       value="<?php echo e($detail->unit_price); ?>">
                            </div>

                            <div class="col-md-3">
                                <input type="number"
                                       name="details[<?php echo e($i); ?>][quantity]"
                                       class="form-control"
                                       value="<?php echo e($detail->quantity); ?>">
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <button type="button"
                        class="btn btn-sm btn-secondary mb-3"
                        onclick="addDetailRow()">
                    <i class="fas fa-plus"></i> Agregar Items
                </button>

                
                <div class="form-group">
                    <label>Observaciones</label>
                    <textarea name="observations"
                              class="form-control"
                              rows="3"><?php echo e(old('observations', $proforma->observations)); ?></textarea>
                </div>

            </div>

            <div class="card-footer">
                <a href="<?php echo e(route('proformas.show', $proforma)); ?>" class="btn btn-secondary">
                    Cancelar
                </a>

                <button type="submit" class="btn btn-warning">
                    Actualizar Proforma
                </button>
            </div>

        </form>
    </div>

</div>

<script>
    let detailIndex = <?php echo e($proforma->details->count()); ?>;

    function addDetailRow() {
        const wrapper = document.getElementById('details-wrapper');

        const row = document.createElement('div');
        row.classList.add('row', 'mb-2');

        row.innerHTML = `
            <div class="col-md-6">
                <input type="text"
                       name="details[${detailIndex}][description]"
                       class="form-control"
                       placeholder="Description">
            </div>
            <div class="col-md-3">
                <input type="number"
                       step="0.01"
                       name="details[${detailIndex}][price]"
                       class="form-control"
                       placeholder="Unit Price">
            </div>
            <div class="col-md-3">
                <input type="number"
                       name="details[${detailIndex}][quantity]"
                       class="form-control"
                       placeholder="Qty"
                       value="1">
            </div>
        `;

        wrapper.appendChild(row);
        detailIndex++;
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\TitulacionHeavy-respaldo\resources\views/proformas/edit.blade.php ENDPATH**/ ?>