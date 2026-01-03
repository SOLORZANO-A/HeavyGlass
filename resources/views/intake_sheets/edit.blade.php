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
                        @foreach (['empty'=>'Vacío','1/4'=>'1/4','1/2'=>'1/2','3/4'=>'3/4','full'=>'Lleno'] as $v => $l)
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
                @foreach (['has_dents'=>'Abolladuras','has_scratches'=>'Arañazos','has_cracks'=>'Grietas'] as $f => $l)
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
                <img src="{{ asset('storage/' . $photo->path) }}"
                     class="img-thumbnail mb-2"
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="take-photo">Tomar foto</button>
                </div>

            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
let stream = null;

const cameraModal = new bootstrap.Modal(document.getElementById('cameraModal'));
const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const openCameraBtn = document.getElementById('open-camera');
const takePhotoBtn = document.getElementById('take-photo');
const photoInput = document.getElementById('photo-input');
const preview = document.getElementById('photo-preview');

/* ================== CÁMARA ================== */
openCameraBtn.onclick = async () => {
    try {
        stream = await navigator.mediaDevices.getUserMedia({ video: true });
        video.srcObject = stream;
        cameraModal.show();
    } catch {
        Swal.fire('Error', 'No se pudo acceder a la cámara', 'error');
    }
};

takePhotoBtn.onclick = () => {
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext('2d').drawImage(video, 0, 0);

    canvas.toBlob(blob => {
        const file = new File([blob], `camera_${Date.now()}.jpg`, { type: 'image/jpeg' });
        const dt = new DataTransfer();

        Array.from(photoInput.files).forEach(f => dt.items.add(f));
        dt.items.add(file);
        photoInput.files = dt.files;

        renderPreview(file);
    });

    stopCamera();
    cameraModal.hide();
};

function stopCamera() {
    if (stream) {
        stream.getTracks().forEach(t => t.stop());
        stream = null;
    }
}

/* ================== PREVIEW ================== */
photoInput.addEventListener('change', () => {
    preview.innerHTML = '';
    Array.from(photoInput.files).forEach(renderPreview);
});

function renderPreview(file) {
    const col = document.createElement('div');
    col.className = 'col-md-3 mb-2';

    const img = document.createElement('img');
    img.src = URL.createObjectURL(file);
    img.className = 'img-fluid rounded border';

    col.appendChild(img);
    preview.appendChild(col);
}

/* ================== ELIMINAR FOTO ================== */
document.querySelectorAll('.btn-delete-photo').forEach(button => {
    button.addEventListener('click', function () {
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
