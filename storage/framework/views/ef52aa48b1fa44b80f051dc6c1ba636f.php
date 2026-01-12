

<?php $__env->startSection('title', 'Inspección Vehicular'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Hoja de Ingreso - Inspección Vehicular</h3>
        </div>

        <form action="<?php echo e(route('intake_inspections.store')); ?>"
              method="POST"
              enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="intake_sheet_id" value="<?php echo e($intakeSheet->id); ?>">

            <div class="card-body">

                
                <ul class="nav nav-tabs" role="tablist">
                    <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e($loop->first ? 'active' : ''); ?>"
                               data-toggle="tab"
                               href="#zone-<?php echo e($zone->id); ?>"
                               role="tab">
                                <?php echo e($zone->name); ?>

                            </a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>

                
                <div class="tab-content mt-3">

                    <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="tab-pane fade <?php echo e($loop->first ? 'show active' : ''); ?>"
                             id="zone-<?php echo e($zone->id); ?>"
                             role="tabpanel">

                            
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead class="thead-light text-center">
                                        <tr>
                                            <th>Pieza</th>
                                            <th>Cambio</th>
                                            <th>Pintura</th>
                                            <th>Fibra</th>
                                            <th>Enderezado</th>
                                            <th>Fisura</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $zone->parts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $part): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($part->name); ?></td>

                                                <?php $__currentLoopData = ['change', 'paint', 'fiber', 'dent', 'crack']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <td class="text-center">
                                                        <input type="checkbox"
                                                               value="1"
                                                               name="items[<?php echo e($zone->id); ?>][<?php echo e($part->id); ?>][<?php echo e($field); ?>]">
                                                    </td>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>

                            
                            <div class="form-group mt-3">
                                <label>Fotos de <?php echo e($zone->name); ?></label>
                                <input type="file"
                                       name="photos[<?php echo e($zone->id); ?>][]"
                                       class="form-control"
                                       multiple
                                       accept="image/*">
                                <small class="text-muted">
                                    Puede subir varias imágenes para esta zona
                                </small>
                            </div>

                            
                            <div class="form-group">
                                <label>Observaciones</label>
                                <textarea name="observations[<?php echo e($zone->id); ?>]"
                                          class="form-control"
                                          rows="2"
                                          placeholder="Observaciones específicas de <?php echo e($zone->name); ?>"></textarea>
                            </div>

                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>
            </div>

            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary">
                    Guardar Inspección
                </button>
            </div>

        </form>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\HeavyGlass-main\resources\views/intake_sheets/inspection.blade.php ENDPATH**/ ?>