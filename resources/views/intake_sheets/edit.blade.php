@extends('layouts.app')

@section('title', 'Editar Hoja de Ingreso')

@section('content')
    <div class="container-fluid">

        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Editar Hoja de Ingreso</h3>
            </div>

            {{-- ================== FORM PRINCIPAL (SOLO DATOS) ================== --}}
            <form action="{{ route('intake_sheets.update', $intakeSheet) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card-body">

                    {{-- VEHÍCULO --}}
                    <div class="form-group">
                        <label>Vehículo</label>
                        <input type="text" class="form-control" readonly
                            value="{{ $intakeSheet->vehicle->plate }} - {{ $intakeSheet->vehicle->brand }} {{ $intakeSheet->vehicle->model }}">
                    </div>

                    {{-- FECHA --}}
                    <div class="form-group">
                        <label>Fecha y hora de ingreso</label>
                        <input type="datetime-local" name="entry_at" class="form-control"
                            value="{{ optional($intakeSheet->entry_at)->format('Y-m-d\TH:i') }}">
                    </div>

                    {{-- KM --}}
                    <div class="form-group">
                        <label>Kilometraje</label>
                        <input type="number" name="km_at_entry" class="form-control"
                            value="{{ old('km_at_entry', $intakeSheet->km_at_entry) }}">
                    </div>

                    {{-- COMBUSTIBLE --}}
                    <div class="form-group">
                        <label>Combustible</label>
                        <select name="fuel_level" class="form-control">
                            @foreach (['empty' => 'Vacío', '1/4' => '1/4', '1/2' => '1/2', '3/4' => '3/4', 'full' => 'Lleno'] as $v => $l)
                                <option value="{{ $v }}"
                                    {{ old('fuel_level', $intakeSheet->fuel_level) == $v ? 'selected' : '' }}>
                                    {{ $l }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- CONDICIONES --}}
                    <hr>
                    <label>Condiciones del vehículo</label>
                    @foreach (['has_dents' => 'Abolladuras', 'has_scratches' => 'Arañazos', 'has_cracks' => 'Grietas'] as $f => $l)
                        <div class="form-check">
                            <input type="checkbox" name="{{ $f }}" class="form-check-input" value="1"
                                {{ old($f, $intakeSheet->$f) ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $l }}</label>
                        </div>
                    @endforeach

                    {{-- NUEVAS FOTOS --}}
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

                    {{-- PREVIEW NUEVAS --}}
                    <div id="photo-preview" class="row mt-2"></div>

                    {{-- TEXTOS --}}
                    <hr>
                    <label>Objetos de valor</label>
                    <textarea name="valuables" class="form-control">{{ old('valuables', $intakeSheet->valuables) }}</textarea>

                    <label class="mt-2">Observaciones</label>
                    <textarea name="observations" class="form-control">{{ old('observations', $intakeSheet->observations) }}</textarea>
                </div>
                {{-- ================= INSPECCIÓN (EDITABLE) ================= --}}
                @if ($intakeSheet->inspection)
                    <hr>
                    <h4 class="mt-4">🔍 Inspección Vehicular</h4>

                    @foreach ($intakeSheet->inspection->items->groupBy('inspection_zone_id') as $zoneItems)
                        @php
                            $zone = $zoneItems->first()->zone;
                        @endphp

                        <div class="card mt-3">
                            <div class="card-header bg-light">
                                <strong>{{ $zone->name }}</strong>
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
                                        @foreach ($zoneItems as $item)
                                            <tr>
                                                <td>{{ $item->part->name }}</td>

                                                @foreach (['change', 'paint', 'fiber', 'dent', 'crack'] as $f)
                                                    <td class="text-center">
                                                        <input type="checkbox"
                                                            name="inspection[{{ $zone->id }}][{{ $item->inspection_part_id }}][{{ $f }}]"
                                                            {{ $item->$f ? 'checked' : '' }}>
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {{-- OBSERVACIONES POR ZONA --}}
                            <div class="card-body">
                                <label class="mb-1">Observaciones</label>
                                <textarea name="inspection_observations[{{ $zone->id }}]" class="form-control" rows="2">{{ $intakeSheet->inspection->observations[$zone->id] ?? '' }}</textarea>
                            </div>
                            @php
                                $zonePhotos = $intakeSheet->inspection->photos->where('inspection_zone_id', $zone->id);
                            @endphp

                            @if ($zonePhotos->count())
                                <div class="card-footer">
                                    <strong>Fotos de {{ $zone->name }}:</strong>

                                    <div class="row mt-2">
                                        @foreach ($zonePhotos as $photo)
                                            <div class="col-md-3 col-6 mb-2">
                                                <a href="{{ asset('storage/' . $photo->path) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $photo->path) }}"
                                                        class="img-fluid rounded border"
                                                        style="object-fit: cover; height: 150px;">
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                        </div>
                    @endforeach
                @else
                    <div class="alert alert-info mt-4">
                        <i class="fas fa-info-circle"></i>
                        Esta hoja de ingreso aún no tiene inspección vehicular.
                    </div>
                @endif


                <div class="card-footer">
                    <a href="{{ route('intake_sheets.show', $intakeSheet) }}" class="btn btn-secondary">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-warning">
                        Actualizar hoja
                    </button>
                </div>
            </form>
        </div>

        {{-- ================== FOTOS EXISTENTES (FUERA DEL FORM) ================== --}}
        <hr>
        <h5>Fotos registradas</h5>

        <div class="row">
            @forelse ($intakeSheet->photos as $photo)
                <div class="col-md-3 mb-3 text-center">
                    <img src="{{ asset('storage/' . $photo->path) }}" class="img-thumbnail mb-2"
                        style="height:150px; object-fit:cover;">

                    <form action="{{ route('intake_photos.destroy', $photo) }}" method="POST" class="delete-photo-form">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger btn-sm btn-delete-photo">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            @empty
                <p class="text-muted">No hay fotos registradas</p>
            @endforelse
        </div>

        {{-- ================== MODAL CÁMARA ================== --}}
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
@endsection

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
    {{-- eliminarfoto --}}
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
@endpush
