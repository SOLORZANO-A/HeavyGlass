@extends('layouts.app')

@section('title', 'Inspección Vehicular')

@section('content')
    <div class="container-fluid">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Hoja de Ingreso - Inspección Vehicular</h3>
            </div>

            <form action="{{ route('intake_inspections.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="intake_sheet_id" value="{{ $intakeSheet->id }}">

                <div class="card-body">

                    {{-- TABS DE ZONAS --}}
                    <ul class="nav nav-tabs" role="tablist">
                        @foreach ($zones as $zone)
                            <li class="nav-item">
                                <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab"
                                    href="#zone-{{ $zone->id }}" role="tab">
                                    {{ $zone->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    {{-- CONTENIDO DE ZONAS --}}
                    <div class="tab-content mt-3">

                        @foreach ($zones as $zone)
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="zone-{{ $zone->id }}"
                                role="tabpanel">

                                {{-- TABLA DE PIEZAS --}}
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
                                            @foreach ($zone->parts as $part)
                                                <tr>
                                                    <td>{{ $part->name }}</td>

                                                    @foreach (['change', 'paint', 'fiber', 'dent', 'crack'] as $field)
                                                        <td class="text-center">
                                                            <input type="checkbox" value="1"
                                                                name="items[{{ $zone->id }}][{{ $part->id }}][{{ $field }}]">
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                {{-- ===================== FOTOS POR ZONA ===================== --}}
                                <div class="form-group mt-3">
                                    <label>Fotos de {{ $zone->name }}</label>

                                    <div class="d-flex gap-2 mb-2">
                                        <button type="button" class="btn btn-primary btn-sm"
                                            onclick="openFilePicker({{ $zone->id }})">
                                            <i class="fas fa-upload"></i> Subir fotos
                                        </button>

                                        <button type="button" class="btn btn-success btn-sm"
                                            onclick="openCamera({{ $zone->id }})">
                                            <i class="fas fa-camera"></i> Abrir cámara
                                        </button>
                                    </div>

                                    <input type="file" id="photo-input-{{ $zone->id }}"
                                        name="photos[{{ $zone->id }}][]" multiple accept="image/*" hidden>

                                    <div id="photo-preview-{{ $zone->id }}" class="row mt-2"></div>
                                </div>


                                {{-- OBSERVACIONES POR ZONA --}}
                                <div class="form-group">
                                    <label>Observaciones</label>
                                    <textarea name="observations[{{ $zone->id }}]" class="form-control" rows="2"
                                        placeholder="Observaciones específicas de {{ $zone->name }}"></textarea>
                                </div>

                            </div>
                        @endforeach
                        {{-- ================= MODAL CÁMARA ================= --}}
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
@endsection

@push('scripts')
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
@endpush
