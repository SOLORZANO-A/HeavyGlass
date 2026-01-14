<?php $__env->startSection('title', 'Editar Hoja de Ingreso'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">

        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Editar Hoja de Ingreso</h3>
            </div>

            
            <form action="<?php echo e(route('intake_sheets.update', $intakeSheet)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="card-body">

                    
                    <div class="form-group">
                        <label>Vehículo</label>
                        <input type="text" class="form-control" readonly
                            value="<?php echo e($intakeSheet->vehicle->plate); ?> - <?php echo e($intakeSheet->vehicle->brand); ?> <?php echo e($intakeSheet->vehicle->model); ?>">
                    </div>

                    
                    <div class="form-group">
                        <label>Fecha y hora de ingreso</label>
                        <input type="datetime-local" name="entry_at" class="form-control"
                            value="<?php echo e(optional($intakeSheet->entry_at)->format('Y-m-d\TH:i')); ?>">
                    </div>

                    
                    <div class="form-group">
                        <label>Kilometraje</label>
                        <input type="number" name="km_at_entry" class="form-control"
                            value="<?php echo e(old('km_at_entry', $intakeSheet->km_at_entry)); ?>">
                    </div>

                    
                    <div class="form-group">
                        <label>Combustible</label>
                        <select name="fuel_level" class="form-control">
                            <?php $__currentLoopData = ['empty' => 'Vacío', '1/4' => '1/4', '1/2' => '1/2', '3/4' => '3/4', 'full' => 'Lleno']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v => $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($v); ?>"
                                    <?php echo e(old('fuel_level', $intakeSheet->fuel_level) == $v ? 'selected' : ''); ?>>
                                    <?php echo e($l); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    
                    <hr>
                    <label>Condiciones del vehículo</label>
                    <?php $__currentLoopData = ['has_dents' => 'Abolladuras', 'has_scratches' => 'Arañazos', 'has_cracks' => 'Grietas']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f => $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="form-check">
                            <input type="checkbox" name="<?php echo e($f); ?>" class="form-check-input" value="1"
                                <?php echo e(old($f, $intakeSheet->$f) ? 'checked' : ''); ?>>
                            <label class="form-check-label"><?php echo e($l); ?></label>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    
                    <hr>
                    <label>Agregar nuevas fotos</label>

                    <div class="d-flex gap-2 mb-2">
                        <button type="button" class="btn btn-primary btn-sm"
                            onclick="document.getElementById('photo-input').click()">
                            <i class="fas fa-upload"></i> Subir fotos
                        </button>

                        <button type="button" class="btn btn-success btn-sm" id="open-camera">
                            <i class="fas fa-camera"></i> Abrir cámara
                        </button>
                    </div>

                    <input type="file" id="photo-input" name="photos[]" multiple accept="image/*" hidden>

                    
                    <div id="photo-preview" class="row mt-2"></div>

                    
                    <hr>
                    <label>Objetos de valor</label>
                    <textarea name="valuables" class="form-control"><?php echo e(old('valuables', $intakeSheet->valuables)); ?></textarea>

                    <label class="mt-2">Observaciones</label>
                    <textarea name="observations" class="form-control"><?php echo e(old('observations', $intakeSheet->observations)); ?></textarea>
                </div>
                
                <?php if($intakeSheet->inspection): ?>
                    <hr>
                    <h4 class="mt-4">🔍 Inspección Vehicular</h4>

                    <?php $__currentLoopData = $intakeSheet->inspection->items->groupBy('inspection_zone_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zoneItems): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $zone = $zoneItems->first()->zone;
                        ?>

                        <div class="card mt-3">
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

                                                <?php $__currentLoopData = ['change', 'paint', 'fiber', 'dent', 'crack']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <td class="text-center">
                                                        <input type="checkbox"
                                                            name="inspection[<?php echo e($zone->id); ?>][<?php echo e($item->inspection_part_id); ?>][<?php echo e($f); ?>]"
                                                            <?php echo e($item->$f ? 'checked' : ''); ?>>
                                                    </td>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>

                            
                            <div class="card-body">
                                <label class="mb-1">Observaciones</label>
                                <textarea name="inspection_observations[<?php echo e($zone->id); ?>]" class="form-control" rows="2"><?php echo e($intakeSheet->inspection->observations[$zone->id] ?? ''); ?></textarea>
                            </div>
                            <?php
                                $zonePhotos = $intakeSheet->inspection->photos->where('inspection_zone_id', $zone->id);
                            ?>

                            <?php if($zonePhotos->count()): ?>
                                <div class="card-footer">
                                    <strong>Fotos de <?php echo e($zone->name); ?>:</strong>

                                    <div class="row mt-2">
                                        <?php $__currentLoopData = $zonePhotos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col-md-3 col-6 mb-2">
                                                <a href="<?php echo e(asset('storage/' . $photo->path)); ?>" target="_blank">
                                                    <img src="<?php echo e(asset('storage/' . $photo->path)); ?>"
                                                        class="img-fluid rounded border"
                                                        style="object-fit: cover; height: 150px;">
                                                </a>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <div class="alert alert-info mt-4">
                        <i class="fas fa-info-circle"></i>
                        Esta hoja de ingreso aún no tiene inspección vehicular.
                    </div>
                <?php endif; ?>


                <div class="card-footer">
                    <a href="<?php echo e(route('intake_sheets.show', $intakeSheet)); ?>" class="btn btn-secondary">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-warning">
                        Actualizar hoja
                    </button>
                </div>
            </form>
        </div>

        
        <hr>
        <h5>Fotos registradas</h5>

        <div class="row">
            <?php $__empty_1 = true; $__currentLoopData = $intakeSheet->photos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="col-md-3 mb-3 text-center">
                    <img src="<?php echo e(asset('storage/' . $photo->path)); ?>" class="img-thumbnail mb-2"
                        style="height:150px; object-fit:cover;">

                    <form action="<?php echo e(route('intake_photos.destroy', $photo)); ?>" method="POST" class="delete-photo-form">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="button" class="btn btn-danger btn-sm btn-delete-photo">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-muted">No hay fotos registradas</p>
            <?php endif; ?>
        </div>

        
        <div class="modal fade" id="cameraModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Cámara</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body text-center">
                        <video id="video" autoplay class="w-100 border"></video>
                        <canvas id="canvas" class="d-none"></canvas>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="take-photo">Tomar foto</button>
                    </div>

                </div>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        /* =========================================================
                                       BUFFER GLOBAL (FUENTE ÚNICA DE VERDAD)
                                    ========================================================= */
        let photosBuffer = []; // ⬅️ AQUÍ SE GUARDAN TODAS LAS FOTOS
        let stream = null;

        const photoInput = document.getElementById('photo-input');
        const preview = document.getElementById('photo-preview');
        const openCameraBtn = document.getElementById('open-camera');
        const takePhotoBtn = document.getElementById('take-photo');
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');

        /* =========================================================
           SELECT2 VEHÍCULOS
        ========================================================= */
        $(document).ready(function() {
            $('#vehicle_id').select2({
                placeholder: 'Escriba placa, marca o modelo',
                width: '100%',
                minimumResultsForSearch: 0
            });
        });
    </script>

    
    <script>
        photoInput.addEventListener('change', function() {

            Array.from(this.files).forEach(file => {
                photosBuffer.push(file); // ✅ SOLO AGREGAMOS
            });

            syncInputFiles();
            renderPreview();
        });
    </script>

    
    <script>
        openCameraBtn.onclick = async () => {
            try {
                stream = await navigator.mediaDevices.getUserMedia({
                    video: true
                });
                video.srcObject = stream;
                $('#cameraModal').modal('show');
            } catch {
                Swal.fire('Error', 'No se pudo acceder a la cámara', 'error');
            }
        };
    </script>

    
    <script>
        takePhotoBtn.onclick = () => {

            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0);

            canvas.toBlob(blob => {
                const file = new File(
                    [blob],
                    `camera_${Date.now()}.jpg`, {
                        type: 'image/jpeg'
                    }
                );

                photosBuffer.push(file); // ✅ AGREGAR AL BUFFER
                syncInputFiles();
                renderPreview();
            });

            $('#cameraModal').modal('hide');
        };
    </script>

    
    <script>
        function syncInputFiles() {
            const dt = new DataTransfer();
            photosBuffer.forEach(file => dt.items.add(file));
            photoInput.files = dt.files;
        }
    </script>

    
    <script>
        function renderPreview() {
            preview.innerHTML = '';

            photosBuffer.forEach((file, index) => {
                const col = document.createElement('div');
                col.className = 'col-md-3 mb-2';

                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.className = 'img-fluid rounded border';

                col.appendChild(img);
                preview.appendChild(col);
            });
        }
    </script>

    
    <script>
        $('#cameraModal').on('hidden.bs.modal', function() {
            if (stream) {
                stream.getTracks().forEach(t => t.stop());
                stream = null;
            }
        });
    </script>

    
    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            if ($('#cameraModal').hasClass('show')) {
                e.preventDefault();
                Swal.fire(
                    'Cámara abierta',
                    'Cierre la cámara antes de guardar',
                    'warning'
                );
            }
        });
    </script>
    
    <script>
        document.querySelectorAll('.btn-delete-photo').forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('form');

                Swal.fire({
                    title: '¿Eliminar foto?',
                    text: 'Esta acción no eliminará la hoja de ingreso',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\HeavyGlass-main\resources\views/intake_sheets/edit.blade.php ENDPATH**/ ?>