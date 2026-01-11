@extends('layouts.app')

@section('title', 'Hoja de Ingreso')

@section('content')
    <div class="container-fluid">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Hoja de Ingreso de Vehículo</h3>
            </div>

            <form action="{{ route('intake_sheets.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="card-body">

                    {{-- VEHÍCULO --}}
                    <div class="form-group">
                        <label>Vehículo</label>

                        <select name="vehicle_id" id="vehicle_id"
                            class="form-control select2 @error('vehicle_id') is-invalid @enderror" required>

                            <option value="">-- Seleccione Vehículo --</option>

                            @foreach ($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}"
                                    {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                    {{ $vehicle->plate }} - {{ $vehicle->brand }} {{ $vehicle->model }}
                                </option>
                            @endforeach
                        </select>

                        @error('vehicle_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>


                    {{-- FECHA --}}
                    <div class="form-group">
                        <label>Fecha y hora de ingreso</label>
                        <input type="datetime-local" name="entry_at" class="form-control" required>
                    </div>

                    {{-- KM / COMBUSTIBLE --}}
                    <div class="row">
                        <div class="col-md-4">
                            <label>Kilometraje</label>
                            <input type="number" name="km_at_entry" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label>Nivel de combustible</label>
                            <select name="fuel_level" class="form-control">
                                <option value="">-- Seleccione --</option>
                                <option value="empty">Vacío</option>
                                <option value="1/4">1/4</option>
                                <option value="1/2">1/2</option>
                                <option value="3/4">3/4</option>
                                <option value="full">Full</option>
                            </select>
                        </div>
                    </div>

                    {{-- CONDICIONES --}}
                    <div class="form-group mt-3">
                        <label>Condiciones del vehículo</label>
                        <div class="form-check">
                            <input type="checkbox" name="has_dents" value="1" class="form-check-input">
                            <label class="form-check-label">Abolladuras</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="has_scratches" value="1" class="form-check-input">
                            <label class="form-check-label">Arañazos</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="has_cracks" value="1" class="form-check-input">
                            <label class="form-check-label">Grietas / Vidrios</label>
                        </div>
                    </div>

                    {{-- FOTOS --}}
                    <div class="form-group mt-3">
                        <label>Fotos del vehículo</label>

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
                    </div>

                    {{-- MODAL CÁMARA --}}
                    <div class="modal fade" id="cameraModal" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">Cámara del vehículo</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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

                    {{-- VALUABLES --}}
                    <div class="form-group">
                        <label>Objetos de valor</label>
                        <textarea name="valuables" class="form-control" rows="2"></textarea>
                    </div>

                    {{-- OBSERVACIONES --}}
                    <div class="form-group">
                        <label>Observaciones</label>
                        <textarea name="observations" class="form-control" rows="3"></textarea>
                    </div>

                </div>

                <div class="card-footer">
                    <a href="{{ route('intake_sheets.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar hoja de ingreso</button>
                </div>

            </form>
        </div>

    </div>
@endsection

@push('styles')
    <style>
        /* Select2 altura igual a inputs */
        .select2-container .select2-selection--single {
            height: 38px;
            padding: 4px 8px;
            border: 1px solid #ced4da;
            border-radius: .25rem;
        }

        .select2-selection__rendered {
            line-height: 28px !important;
        }

        .select2-selection__arrow {
            height: 36px;
        }

        /* Mejor dropdown */
        .select2-dropdown {
            border-radius: .25rem;
        }
    </style>
@endpush

@push('scripts')
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

    {{-- =========================================================
   SUBIR FOTOS DESDE PC (NO BORRA LAS EXISTENTES)
========================================================= --}}
    <script>
        photoInput.addEventListener('change', function() {

            Array.from(this.files).forEach(file => {
                photosBuffer.push(file); // ✅ SOLO AGREGAMOS
            });

            syncInputFiles();
            renderPreview();
        });
    </script>

    {{-- =========================================================
   ABRIR CÁMARA
========================================================= --}}
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

    {{-- =========================================================
   TOMAR FOTO DESDE CÁMARA
========================================================= --}}
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

    {{-- =========================================================
   SINCRONIZAR BUFFER → INPUT FILE
========================================================= --}}
    <script>
        function syncInputFiles() {
            const dt = new DataTransfer();
            photosBuffer.forEach(file => dt.items.add(file));
            photoInput.files = dt.files;
        }
    </script>

    {{-- =========================================================
   PREVIEW DE TODAS LAS FOTOS
========================================================= --}}
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

    {{-- =========================================================
   APAGAR CÁMARA AL CERRAR MODAL
========================================================= --}}
    <script>
        $('#cameraModal').on('hidden.bs.modal', function() {
            if (stream) {
                stream.getTracks().forEach(t => t.stop());
                stream = null;
            }
        });
    </script>

    {{-- =========================================================
   EVITAR SUBMIT SI CÁMARA ESTÁ ABIERTA
========================================================= --}}
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
@endpush
