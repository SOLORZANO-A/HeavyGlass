@extends('layouts.app')

@section('title', 'Editar Cliente')

@section('content')
    <div class="container-fluid">

        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Editar Cliente</h3>
            </div>

            <form action="{{ route('clients.update', $client) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card-body">

                    {{-- NOMBRES --}}
                    <div class="form-group">
                        <label>Primer nombre</label>
                        <input type="text"
                               name="first_name"
                               class="form-control @error('first_name') is-invalid @enderror"
                               value="{{ old('first_name', $client->first_name) }}">
                        @error('first_name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Apellido</label>
                        <input type="text"
                               name="last_name"
                               class="form-control @error('last_name') is-invalid @enderror"
                               value="{{ old('last_name', $client->last_name) }}">
                        @error('last_name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- DOCUMENTO --}}
                    <div class="form-group">
                        <label>Cédula de identidad</label>
                        <input type="text"
                               name="document"
                               class="form-control @error('document') is-invalid @enderror"
                               value="{{ old('document', $client->document) }}">
                        @error('document')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- COPIA DE CÉDULA --}}
                    <div class="form-group">
                        <label>Copia de cédula</label>
                        <input type="file" name="id_copy" class="form-control">

                        @if ($client->id_copy_path)
                            <small class="form-text text-muted">
                                Archivo actual:
                                <a href="{{ asset('storage/' . $client->id_copy_path) }}" target="_blank">
                                    Ver copia
                                </a>
                            </small>
                        @endif

                        @error('id_copy')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- CONTACTO --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Teléfono</label>
                                <input type="text"
                                       name="phone"
                                       class="form-control"
                                       value="{{ old('phone', $client->phone) }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Correo electrónico</label>
                                <input type="email"
                                       name="email"
                                       class="form-control"
                                       value="{{ old('email', $client->email) }}">
                            </div>
                        </div>
                    </div>

                    {{-- DIRECCIÓN --}}
                    <div class="form-group">
                        <label>Dirección</label>
                        <input type="text"
                               name="address"
                               class="form-control"
                               value="{{ old('address', $client->address) }}">
                    </div>

                     <div class="form-group">
                        <label>Numero de referencia</label>
                        <input type="text" name="reference_number" class="form-control" value="{{ old('reference_number', $client->reference_number) }}">
                    </div>

                    {{-- TIPO DE CLIENTE --}}
                    <div class="form-group">
                        <label>Tipo de cliente</label>
                        <select name="client_type"
                                class="form-control @error('client_type') is-invalid @enderror">
                            <option value="">-- Seleccione --</option>

                            <option value="owner"
                                {{ old('client_type', $client->client_type) == 'owner' ? 'selected' : '' }}>
                                Dueño del vehículo
                            </option>

                            <option value="third"
                                {{ old('client_type', $client->client_type) == 'third' ? 'selected' : '' }}>
                                Tercero (No propietario)
                            </option>
                            <option value="insurance"
                                {{ old('client_type', $client->client_type) == 'insurance' ? 'selected' : '' }}>
                                Aseguradora
                            </option>
                        </select>

                        @error('client_type')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- DESCRIPCIÓN --}}
                    <div class="form-group">
                        <label>Descripción / Observaciones</label>
                        <textarea name="description"
                                  class="form-control"
                                  rows="3">{{ old('description', $client->description) }}</textarea>
                    </div>

                </div>

                {{-- BOTONES --}}
                <div class="card-footer">
                    <a href="{{ route('clients.index') }}" class="btn btn-secondary">
                        Cancelar
                    </a>

                    <button type="submit" class="btn btn-warning">
                        Actualizar Cliente
                    </button>
                </div>

            </form>
        </div>

    </div>
@endsection
