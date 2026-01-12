<?php $__env->startSection('title', 'Intake Sheet Details'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">
                    Hoja de Ingreso #<?php echo e($intakeSheet->id); ?>

                </h3>

                <div class="card-tools">
                    <a href="<?php echo e(route('intake_sheets.edit', $intakeSheet)); ?>" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Editar
                    </a>

                    <a href="<?php echo e(route('intake_sheets.index')); ?>" class="btn btn-secondary btn-sm">
                        Volver
                    </a>
                </div>
            </div>

            <div class="card-body">

                <table class="table table-bordered">

                    
                    <tr>
                        <th width="250">Vehículo</th>
                        <td>
                            <?php echo e($intakeSheet->vehicle?->plate ?? '—'); ?> —
                            <?php echo e($intakeSheet->vehicle?->brand ?? ''); ?>

                            <?php echo e($intakeSheet->vehicle?->model ?? ''); ?>

                        </td>
                    </tr>

                    
                    <tr>
                        <th>Cliente</th>
                        <td>
                            <?php echo e($intakeSheet->vehicle?->client?->fullName() ?? '—'); ?>

                        </td>
                    </tr>

                    
                    <tr>
                        <th>Fecha de Ingreso</th>
                        <td>
                            <?php echo e($intakeSheet->entry_at ? $intakeSheet->entry_at->format('Y-m-d H:i') : '—'); ?>

                        </td>
                    </tr>

                    
                    <tr>
                        <th>Kilometraje</th>
                        <td><?php echo e($intakeSheet->km_at_entry ?? '—'); ?></td>
                    </tr>

                    
                    <tr>
                        <th>Nivel de Combustible</th>
                        <td><?php echo e(ucfirst($intakeSheet->fuel_level ?? '—')); ?></td>
                    </tr>

                    
                    <tr>
                        <th>Condición del Vehículo</th>
                        <td>
                            <?php if($intakeSheet->has_dents): ?>
                                <span class="badge badge-warning">Abolladuras</span>
                            <?php endif; ?>

                            <?php if($intakeSheet->has_scratches): ?>
                                <span class="badge badge-info">Arañazos</span>
                            <?php endif; ?>

                            <?php if($intakeSheet->has_cracks): ?>
                                <span class="badge badge-danger">Grietas</span>
                            <?php endif; ?>

                            <?php if(!$intakeSheet->has_dents && !$intakeSheet->has_scratches && !$intakeSheet->has_cracks): ?>
                                <span class="text-muted">Sin daños visibles</span>
                            <?php endif; ?>
                        </td>
                    </tr>

                    
                    <tr>
                        <th>Objetos de Valor</th>
                        <td><?php echo e($intakeSheet->valuables ?? '—'); ?></td>
                    </tr>

                    
                    <tr>
                        <th>Observaciones</th>
                        <td><?php echo e($intakeSheet->observations ?? '—'); ?></td>
                    </tr>

                    
                    <tr>
                        <th>Fotos del Vehículo</th>
                        <td>
                            <?php if($intakeSheet->photos && $intakeSheet->photos->count()): ?>
                                <div class="row">
                                    <?php $__currentLoopData = $intakeSheet->photos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-md-3 mb-3">
                                            <a href="<?php echo e(asset('storage/' . $photo->path)); ?>" target="_blank">
                                                <img src="<?php echo e(asset('storage/' . $photo->path)); ?>"
                                                    class="img-fluid img-thumbnail" alt="Foto vehículo">
                                            </a>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php else: ?>
                                <span class="text-muted">No hay fotos registradas</span>
                            <?php endif; ?>
                        </td>
                    </tr>

                </table>
                
                <?php if($intakeSheet->inspection): ?>

                    <hr>
                    <h4 class="mt-4 mb-3">
                        <i class="fas fa-search"></i> Inspección Vehicular
                    </h4>

                    <p class="text-muted">
                        Registrada el
                        <?php echo e($intakeSheet->inspection->created_at->format('d/m/Y H:i')); ?>

                        por <?php echo e($intakeSheet->inspection->createdBy?->name ?? 'Sistema'); ?>

                    </p>

                    <?php $__currentLoopData = $intakeSheet->inspection->items->groupBy('inspection_zone_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zoneItems): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $zone = $zoneItems->first()->zone;
                        ?>

                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <strong><?php echo e($zone->name); ?></strong>
                            </div>

                            <div class="card-body p-0">
                                <table class="table table-bordered mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Pieza</th>
                                            <th class="text-center">Cambio</th>
                                            <th class="text-center">Pintura</th>
                                            <th class="text-center">Fibra</th>
                                            <th class="text-center">Enderezado</th>
                                            <th class="text-center">Fisura</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $zoneItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($item->part->name); ?></td>
                                                <td class="text-center">
                                                    <?php if($item->change): ?>
                                                        <span class="badge badge-success">✔</span>
                                                    <?php else: ?>
                                                        <span class="text-muted">—</span>
                                                    <?php endif; ?>
                                                </td>

                                                <td class="text-center">
                                                    <?php if($item->paint): ?>
                                                        <span class="badge badge-success">✔</span>
                                                    <?php else: ?>
                                                        <span class="text-muted">—</span>
                                                    <?php endif; ?>
                                                </td>

                                                <td class="text-center">
                                                    <?php if($item->fiber): ?>
                                                        <span class="badge badge-success">✔</span>
                                                    <?php else: ?>
                                                        <span class="text-muted">—</span>
                                                    <?php endif; ?>
                                                </td>

                                                <td class="text-center">
                                                    <?php if($item->dent): ?>
                                                        <span class="badge badge-success">✔</span>
                                                    <?php else: ?>
                                                        <span class="text-muted">—</span>
                                                    <?php endif; ?>
                                                </td>

                                                <td class="text-center">
                                                    <?php if($item->crack): ?>
                                                        <span class="badge badge-success">✔</span>
                                                    <?php else: ?>
                                                        <span class="text-muted">—</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>

                            
                            <?php
                                $zoneNotes = $zoneItems->pluck('notes')->filter()->unique();
                            ?>

                            <?php if($zoneNotes->count()): ?>
                                <div class="card-footer">
                                    <strong>Observaciones:</strong>
                                    <ul class="mb-0">
                                        <?php $__currentLoopData = $zoneNotes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><?php echo e($note); ?></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            <?php endif; ?>


                            
                            <?php
                                $photos = $intakeSheet->inspection->photos->where('inspection_zone_id', $zone->id);
                            ?>

                            <?php if($photos->count()): ?>
                                <div class="card-footer">
                                    <strong>Fotos de <?php echo e($zone->name); ?></strong>
                                    <div class="row mt-2">
                                        <?php $__currentLoopData = $photos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col-md-2 col-4 mb-2">
                                                <a href="<?php echo e(asset('storage/' . $photo->path)); ?>" target="_blank">
                                                    <img src="<?php echo e(asset('storage/' . $photo->path)); ?>"
                                                        class="img-fluid rounded border">
                                                </a>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            <?php endif; ?>



                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <div class="alert alert-warning mt-4">
                        <i class="fas fa-exclamation-triangle"></i>
                        Esta hoja de ingreso aún no tiene una inspección vehicular registrada.
                    </div>
                <?php endif; ?>



            </div>

            <div class="card-footer">
                <a href="<?php echo e(route('intake_sheets.index')); ?>" class="btn btn-secondary">
                    Volver al listado
                </a>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\HeavyGlass-main\resources\views/intake_sheets/show.blade.php ENDPATH**/ ?>