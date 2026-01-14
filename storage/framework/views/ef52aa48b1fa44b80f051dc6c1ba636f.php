

<?php $__env->startSection('title', 'Inspección Vehicular'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Hoja de Ingreso - Inspección Vehicular</h3>
            </div>

            <form action="<?php echo e(route('intake_inspections.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="intake_sheet_id" value="<?php echo e($intakeSheet->id); ?>">

                <div class="card-body">

                    
                    <ul class="nav nav-tabs" role="tablist">
                        <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e($loop->first ? 'active' : ''); ?>" data-toggle="tab"
                                    href="#zone-<?php echo e($zone->id); ?>" role="tab">
                                    <?php echo e($zone->name); ?>

                                </a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>

                    
                    <div class="tab-content mt-3">

                        <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="tab-pane fade <?php echo e($loop->first ? 'show active' : ''); ?>" id="zone-<?php echo e($zone->id); ?>"
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
                                                            <input type="checkbox" value="1"
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

                                    <div class="d-flex gap-2 mb-2">
                                        <button type="button" class="btn btn-primary btn-sm"
                                            onclick="openFilePicker(<?php echo e($zone->id); ?>)">
                                            <i class="fas fa-upload"></i> Subir fotos
                                        </button>

                                        <button type="button" class="btn btn-success btn-sm"
                                            onclick="openCamera(<?php echo e($zone->id); ?>)">
                                            <i class="fas fa-camera"></i> Abrir cámara
                                        </button>
                                    </div>

                                    <input type="file" id="photo-input-<?php echo e($zone->id); ?>"
                                        name="photos[<?php echo e($zone->id); ?>][]" multiple accept="image/*" hidden>

                                    <div id="photo-preview-<?php echo e($zone->id); ?>" class="row mt-2"></div>
                                </div>


                                
                                <div class="form-group">
                                    <label>Observaciones</label>
                                    <textarea name="observations[<?php echo e($zone->id); ?>]" class="form-control" rows="2"
                                        placeholder="Observaciones específicas de <?php echo e($zone->name); ?>"></textarea>
                                </div>

                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        
                        <div class="modal fade" id="cameraModal" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Cámara</h5>
                                        <button type="button" class="btn-close" data-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body text-center">
                                        <video id="video" autoplay class="w-100 border"></video>
                                        <canvas id="canvas" class="d-none"></canvas>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                            Cerrar
                                        </button>

                                        <button type="button" class="btn btn-primary" id="take-photo">
                                            Tomar foto
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>

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

<?php $__env->startPush('scripts'); ?>
    <script>
        let currentZone = null;
        let stream = null;

        const photosBuffer = {}; // 🔑 buffers por zona

        function getBuffer(zoneId) {
            if (!photosBuffer[zoneId]) {
                photosBuffer[zoneId] = [];
            }
            return photosBuffer[zoneId];
        }

        function openFilePicker(zoneId) {
            document.getElementById(`photo-input-${zoneId}`).click();
        }

        document.querySelectorAll('input[type="file"][id^="photo-input-"]').forEach(input => {
            input.addEventListener('change', function() {
                const zoneId = this.id.replace('photo-input-', '');
                const buffer = getBuffer(zoneId);

                Array.from(this.files).forEach(file => buffer.push(file));

                syncInputFiles(zoneId);
                renderPreview(zoneId);
            });
        });

        function openCamera(zoneId) {
            currentZone = zoneId;

            navigator.mediaDevices.getUserMedia({
                    video: true
                })
                .then(s => {
                    stream = s;
                    document.getElementById('video').srcObject = stream;
                    $('#cameraModal').modal('show');
                })
                .catch(() => {
                    Swal.fire('Error', 'No se pudo acceder a la cámara', 'error');
                });
        }

        document.getElementById('take-photo').onclick = () => {
            const canvas = document.getElementById('canvas');
            const video = document.getElementById('video');

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

                const buffer = getBuffer(currentZone);
                buffer.push(file);

                syncInputFiles(currentZone);
                renderPreview(currentZone);
            });

            $('#cameraModal').modal('hide');
        };

        function syncInputFiles(zoneId) {
            const dt = new DataTransfer();
            getBuffer(zoneId).forEach(file => dt.items.add(file));
            document.getElementById(`photo-input-${zoneId}`).files = dt.files;
        }

        function renderPreview(zoneId) {
            const preview = document.getElementById(`photo-preview-${zoneId}`);
            preview.innerHTML = '';

            getBuffer(zoneId).forEach(file => {
                const col = document.createElement('div');
                col.className = 'col-md-3 mb-2';

                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.className = 'img-fluid rounded border';

                col.appendChild(img);
                preview.appendChild(col);
            });
        }

        $('#cameraModal').on('hidden.bs.modal', function() {
            if (stream) {
                stream.getTracks().forEach(t => t.stop());
                stream = null;
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\HeavyGlass-main\resources\views/intake_sheets/inspection.blade.php ENDPATH**/ ?>