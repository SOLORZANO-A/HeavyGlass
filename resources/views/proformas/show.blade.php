@extends('layouts.app')

@section('title', 'Detalle de Proforma')

@section('content')
    @php
        use Illuminate\Support\Facades\Storage;
    @endphp

    <div class="container-fluid">

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">
                    Proforma #{{ $proforma->id }}
                </h3>

                <div class="card-tools">
                    <a href="{{ route('proformas.index') }}" class="btn btn-secondary btn-sm">
                        Volver
                    </a>
                </div>
            </div>

            <div class="card-body">

                {{-- ================== DATOS GENERALES ================== --}}
                <table class="table table-bordered mb-4">
                    <tr>
                        <th width="250">Orden de trabajo</th>
                        <td>
                            @if ($proforma->workOrder)
                                #{{ $proforma->workOrder->id }} —
                                {{ $proforma->vehicle_plate }}
                            @else
                                <span class="text-muted">No asignada</span>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th>Cliente</th>
                        <td>{{ $proforma->client_name }}</td>
                    </tr>

                    <tr>
                        <th>Documento</th>
                        <td>{{ $proforma->client_document }}</td>
                    </tr>

                    <tr>
                        <th>Teléfono</th>
                        <td>{{ $proforma->client_phone }}</td>
                    </tr>

                    <tr>
                        <th>Email</th>
                        <td>{{ $proforma->client_email }}</td>
                    </tr>

                    <tr>
                        <th>Vehículo</th>
                        <td>
                            {{ $proforma->vehicle_brand }}
                            {{ $proforma->vehicle_model }}
                            ({{ $proforma->vehicle_plate }})
                        </td>
                    </tr>

                    <tr>
                        <th>Estado de la proforma</th>
                        <td>
                            <span class="badge badge-{{ $proforma->status === 'paid' ? 'success' : 'warning' }}">
                                {{ ucfirst($proforma->status) }}
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <th>Firma del cliente</th>
                        <td>
                            @if ($proforma->isSigned())
                                <span class="badge badge-success">Firmada</span>
                            @else
                                <span class="badge badge-danger">Pendiente</span>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th>Observaciones</th>
                        <td>{{ $proforma->observations ?? '—' }}</td>
                    </tr>
                </table>

                {{-- ================== DETALLES DE LA PROFORMA ================== --}}
                <h5 class="mb-3">Detalles de la Proforma</h5>

                <table class="table table-sm table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>Descripción</th>
                            <th width="120" class="text-center">Precio Unit.</th>
                            <th width="100" class="text-center">Cantidad</th>
                            <th width="140" class="text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($proforma->details as $detail)
                            <tr>
                                <td>{{ $detail->item_description }}</td>
                                <td class="text-center">
                                    ${{ number_format($detail->unit_price, 2) }}
                                </td>
                                <td class="text-center">
                                    {{ $detail->quantity }}
                                </td>
                                <td class="text-right">
                                    ${{ number_format($detail->line_total, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    No existen detalles registrados
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                    {{-- ================== TOTALES ================== --}}
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-right">Subtotal</th>
                            <th class="text-right">
                                ${{ number_format($proforma->subtotal, 2) }}
                            </th>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-right">IVA (15%)</th>
                            <th class="text-right">
                                ${{ number_format($proforma->tax, 2) }}
                            </th>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-right">TOTAL</th>
                            <th class="text-right text-success">
                                <strong>${{ number_format($proforma->total, 2) }}</strong>
                            </th>
                        </tr>
                    </tfoot>
                </table>

                {{-- ================== FIRMA DEL CLIENTE ================== --}}
                {{-- ================== FIRMA DEL CLIENTE ================== --}}
                <hr>
                <h5>Firma del Cliente</h5>

                @if ($proforma->isSigned())
                    <div class="mt-2">
                        <img src="{{ Storage::url($proforma->signature_path) }}?v={{ $proforma->updated_at->timestamp }}"
                            alt="Firma del cliente" class="img-fluid"
                            style="
        max-width: 400px;
        background: #fff;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    ">

                    </div>
                @else
                    <form id="signature-form" action="{{ route('proformas.sign', $proforma) }}" method="POST">
                        @csrf

                        <canvas id="signature-pad"
                            style="border:1px solid #ccc; width:100%; height:200px; background:#fff;">
                        </canvas>

                        <input type="hidden" name="signature" id="signature">

                        <div class="mt-2">
                            <button type="button" id="clear-signature" class="btn btn-secondary btn-sm">
                                Limpiar firma
                            </button>

                            <button type="button" class="btn btn-primary btn-sm" id="btn-save-signature">
                                Guardar firma
                            </button>


                        </div>
                    </form>
                @endif


            </div>
        </div>
    </div>
@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const canvas = document.getElementById('signature-pad');

function isCanvasEmpty(canvas) {
    const blank = document.createElement('canvas');
    blank.width = canvas.width;
    blank.height = canvas.height;
    return canvas.toDataURL() === blank.toDataURL();
}

if (canvas) {
    const ctx = canvas.getContext('2d');

    canvas.width  = canvas.offsetWidth;
    canvas.height = canvas.offsetHeight;

    let drawing = false;

    const getPos = (e) => {
        const rect = canvas.getBoundingClientRect();
        return {
            x: (e.touches ? e.touches[0].clientX : e.clientX) - rect.left,
            y: (e.touches ? e.touches[0].clientY : e.clientY) - rect.top
        };
    };

    const start = (e) => {
        drawing = true;
        const pos = getPos(e);
        ctx.beginPath();
        ctx.moveTo(pos.x, pos.y);
    };

    const draw = (e) => {
        if (!drawing) return;
        const pos = getPos(e);
        ctx.lineWidth = 2.5;
        ctx.lineCap = 'round';
        ctx.strokeStyle = '#000';
        ctx.lineTo(pos.x, pos.y);
        ctx.stroke();
    };

    const end = () => {
        drawing = false;
        ctx.beginPath();
    };

    // Mouse
    canvas.addEventListener('mousedown', start);
    canvas.addEventListener('mousemove', draw);
    canvas.addEventListener('mouseup', end);

    // Touch
    canvas.addEventListener('touchstart', start);
    canvas.addEventListener('touchmove', draw);
    canvas.addEventListener('touchend', end);

    document.getElementById('clear-signature').onclick = () => {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
    };

    // ✅ BOTÓN GUARDAR FIRMA CON VALIDACIÓN REAL
    document.getElementById('btn-save-signature').onclick = () => {

        if (isCanvasEmpty(canvas)) {
            Swal.fire({
                icon: 'warning',
                title: 'Firma requerida',
                text: 'El cliente debe firmar antes de continuar'
            });
            return;
        }

        Swal.fire({
            title: '¿Confirmar firma?',
            text: 'El cliente acepta la proforma y los valores indicados',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, firmar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('signature').value =
                    canvas.toDataURL('image/png');

                document.getElementById('signature-form').submit();
            }
        });
    };
}
</script>

@endpush

