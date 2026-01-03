@extends('layouts.app')

@section('title', 'New Vehicle')

@section('content')
    <div class="container-fluid">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Registrar Vehiculo</h3>
            </div>

            <form action="{{ route('vehicles.store') }}" method="POST">
                @csrf

                <div class="card-body">

                    <div class="form-group">
                        <label>Dueño / Cliente</label>
                        <select name="client_id" id="client_id"
                            class="form-control select2 @error('client_id') is-invalid @enderror">
                            <option value="">-- Selecciona Cliente --</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                    {{ $client->fullName() }} ({{ $client->document }})
                                </option>
                            @endforeach
                        </select>
                        @error('client_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Marca</label>
                                <input type="text" name="brand"
                                    class="form-control @error('brand') is-invalid @enderror" value="{{ old('brand') }}">
                                @error('brand')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Modelo</label>
                                <input type="text" name="model"
                                    class="form-control @error('model') is-invalid @enderror" value="{{ old('model') }}">
                                @error('model')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Placa</label>
                                <input type="text" name="plate"
                                    class="form-control @error('plate') is-invalid @enderror" value="{{ old('plate') }}">
                                @error('plate')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Año</label>
                                <input type="number" name="year" class="form-control" value="{{ old('year') }}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Color</label>
                                <input type="text" name="color" class="form-control" value="{{ old('color') }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Descripcion</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                    </div>

                </div>

                <div class="card-footer">
                    <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">
                        Cancelar
                    </a>

                    <button type="submit" class="btn btn-primary">
                        Guardar
                    </button>
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
        $(document).ready(function() {
            $('#client_id').select2({
                placeholder: 'Escriba nombre o cédula del cliente',
                allowClear: true,
                width: '100%',
                minimumResultsForSearch: 0, // 👈 SIEMPRE muestra el textbox
                matcher: function(params, data) {
                    if ($.trim(params.term) === '') {
                        return data; // 👈 si no hay texto → muestra TODO
                    }

                    if (typeof data.text === 'undefined') {
                        return null;
                    }

                    if (data.text.toLowerCase().includes(params.term.toLowerCase())) {
                        return data; // 👈 filtra mientras escribes
                    }

                    return null;
                }
            });
        });
    </script>
@endpush
