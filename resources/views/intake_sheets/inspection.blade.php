@extends('layouts.app')

@section('title', 'Inspección Vehicular')

@section('content')
<div class="container-fluid">

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Hoja de Ingreso - Inspección Vehicular</h3>
        </div>

        <form action="{{ route('intake_inspections.store') }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="intake_sheet_id" value="{{ $intakeSheet->id }}">

            <div class="card-body">

                {{-- TABS DE ZONAS --}}
                <ul class="nav nav-tabs" role="tablist">
                    @foreach ($zones as $zone)
                        <li class="nav-item">
                            <a class="nav-link {{ $loop->first ? 'active' : '' }}"
                               data-toggle="tab"
                               href="#zone-{{ $zone->id }}"
                               role="tab">
                                {{ $zone->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                {{-- CONTENIDO DE ZONAS --}}
                <div class="tab-content mt-3">

                    @foreach ($zones as $zone)
                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                             id="zone-{{ $zone->id }}"
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
                                                        <input type="checkbox"
                                                               value="1"
                                                               name="items[{{ $zone->id }}][{{ $part->id }}][{{ $field }}]">
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {{-- FOTOS POR ZONA --}}
                            <div class="form-group mt-3">
                                <label>Fotos de {{ $zone->name }}</label>
                                <input type="file"
                                       name="photos[{{ $zone->id }}][]"
                                       class="form-control"
                                       multiple
                                       accept="image/*">
                                <small class="text-muted">
                                    Puede subir varias imágenes para esta zona
                                </small>
                            </div>

                            {{-- OBSERVACIONES POR ZONA --}}
                            <div class="form-group">
                                <label>Observaciones</label>
                                <textarea name="observations[{{ $zone->id }}]"
                                          class="form-control"
                                          rows="2"
                                          placeholder="Observaciones específicas de {{ $zone->name }}"></textarea>
                            </div>

                        </div>
                    @endforeach

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
