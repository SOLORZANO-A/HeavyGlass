<?php $__env->startSection('title', 'Nueva Proforma'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Crear Proforma</h3>
            </div>

            <form action="<?php echo e(route('proformas.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="card-body">

                    
                    <div class="form-group">
                        <label>Orden de trabajo</label>
                        <select name="work_order_id" id="work_order_select" class="form-control select2" required>
                            <option value="">-- Seleccione una Orden de Trabajo --</option>
                            <?php $__currentLoopData = $workOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($order->id); ?>">
                                    #<?php echo e($order->id); ?> —
                                    <?php echo e($order->intakeSheet->vehicle->plate); ?>

                                    | <?php echo e($order->intakeSheet->vehicle->brand); ?>

                                    <?php echo e($order->intakeSheet->vehicle->model); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <hr>

                    
                    <h5>Detalles de la Proforma</h5>

                    <div id="details-wrapper"></div>

                    <button type="button" class="btn btn-sm btn-secondary mb-3" onclick="addDetailRow()">
                        <i class="fas fa-plus"></i> Agregar item manual
                    </button>

                    <hr>

                    <h5 class="mt-3">🛠 Mano de Obra</h5>

                    <div id="labor-wrapper"></div>

                    <button type="button" class="btn btn-sm btn-secondary mb-3" onclick="addLaborRow()">
                        <i class="fas fa-plus"></i> Agregar Mano de Obra
                    </button>
                    </hr>




                    
                    <div class="form-group">
                        <label>Observaciones</label>
                        <textarea name="observations" class="form-control" rows="3"></textarea>
                    </div>

                </div>

                <div class="card-footer">
                    <a href="<?php echo e(route('proformas.index')); ?>" class="btn btn-secondary">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Crear Proforma
                    </button>
                </div>

            </form>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        let detailIndex = 0;

        function addDetailRow(description = '', price = '', quantity = 1) {
            const wrapper = document.getElementById('details-wrapper');

            const row = document.createElement('div');
            row.className = 'row mb-2 align-items-center';

            row.innerHTML = `
        <div class="col-md-6">
            <input type="text"
                   name="details[${detailIndex}][description]"
                   class="form-control"
                   value="${description}"
                   required>
        </div>

        <div class="col-md-3">
            <input type="number"
                   step="0.01"
                   name="details[${detailIndex}][price]"
                   class="form-control"
                   value="${price}">
        </div>

        <div class="col-md-2">
            <input type="number"
                   name="details[${detailIndex}][quantity]"
                   class="form-control"
                   value="${quantity}"
                   min="1">
        </div>

        <div class="col-md-1 text-center">
            <button type="button"
                    class="btn btn-sm btn-danger"
                    onclick="this.closest('.row').remove()">
                ✕
            </button>
        </div>
    `;

            wrapper.appendChild(row);
            detailIndex++;
        }

        document.getElementById('work_order_select')
            .addEventListener('change', function() {

                const workOrderId = this.value;
                const wrapper = document.getElementById('details-wrapper');

                wrapper.innerHTML = '';
                detailIndex = 0;

                if (!workOrderId) return;

                fetch(`/work-orders/${workOrderId}/inspection-data`)
                    .then(res => res.json())
                    .then(items => {

                        if (!items.length) {
                            addDetailRow();
                            return;
                        }

                        items.forEach(item => {
                            addDetailRow(item.description);
                        });
                    });
            });
    </script>

    <script>
        let laborIndex = 0;

        function addLaborRow(description = '', price = '', quantity = 1) {
            const wrapper = document.getElementById('labor-wrapper');

            const row = document.createElement('div');
            row.className = 'row mb-2 align-items-center';

            row.innerHTML = `
        <input type="hidden"
               name="labor[${laborIndex}][type]"
               value="labor">

        <div class="col-md-6">
            <input type="text"
                   name="labor[${laborIndex}][description]"
                   class="form-control"
                   placeholder="Mano de obra"
                   value="${description}"
                   required>
        </div>

        <div class="col-md-3">
            <input type="number"
                   step="0.01"
                   name="labor[${laborIndex}][price]"
                   class="form-control"
                   placeholder="Precio"
                   value="${price}">
        </div>

        <div class="col-md-2">
            <input type="number"
                   name="labor[${laborIndex}][quantity]"
                   class="form-control"
                   value="${quantity}"
                   min="1">
        </div>

        <div class="col-md-1 text-center">
            <button type="button"
                    class="btn btn-sm btn-danger"
                    onclick="this.closest('.row').remove()">✕</button>
        </div>
    `;

            wrapper.appendChild(row);
            laborIndex++;
        }
    </script>
<?php $__env->stopPush(); ?>


<?php $__env->startPush('styles'); ?>
    <style>
        /* Contenedor */
        .select2-container--default .select2-selection--single {
            background-color: #1e1e1e;
            border: 1px solid #444;
            border-radius: 6px;
            height: 42px;
            padding: 6px 12px;
            color: #fff;
        }

        /* Texto */
        .select2-selection__rendered {
            color: #fff !important;
            line-height: 28px !important;
        }

        /* Flecha */
        .select2-selection__arrow {
            height: 40px;
        }

        /* Dropdown */
        .select2-dropdown {
            background-color: #1e1e1e;
            border: 1px solid #444;
        }

        /* Opciones */
        .select2-results__option {
            color: #ddd;
        }

        .select2-results__option--highlighted {
            background-color: #0d6efd !important;
            color: #fff;
        }

        .select2-container .select2-selection--single {
            height: 38px;
            padding: 4px 10px;
            border-radius: .375rem;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\HeavyGlass-main\resources\views/proformas/create.blade.php ENDPATH**/ ?>