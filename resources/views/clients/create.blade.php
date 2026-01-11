@extends('layouts.app')

@section('title', 'New Client')

@section('content')
    <div class="container-fluid">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Nuevo Cliente</h3>
            </div>

            <form action="{{ route('clients.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="card-body">

                    <div class="form-group">
                        <label>Primer nombre</label>
                        <input type="text" name="first_name"
                            class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}">
                        @error('first_name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Apellido</label>
                        <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror"
                            value="{{ old('last_name') }}">
                        @error('last_name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Cedula de Identidad</label>
                        <input type="text" name="document" class="form-control @error('document') is-invalid @enderror"
                            value="{{ old('document') }}">
                        @error('document')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Copia de cédula</label>
                        <input type="file" name="id_copy" class="form-control">

                        @error('id_copy')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>



                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Telefono celular</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Dirrecion</label>
                        <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                    </div>

                    <div class="form-group">
<<<<<<< HEAD
                        <label>Numero de referencia</label>
                        <input type="text" name="reference_number" class="form-control" value="{{ old('reference_number') }}">
                    </div>

                    <div class="form-group">
=======
>>>>>>> 964613b02c73302aea2dc33386313b314db28634
                        <label>Tipo de cliente</label>
                        <select name="client_type" class="form-control @error('client_type') is-invalid @enderror">
                            <option value="">-- Selecciona --</option>
                            <option value="owner" {{ old('client_type') == 'owner' ? 'selected' : '' }}>
                                Dueño
                            </option>
                            <option value="third" {{ old('client_type') == 'third' ? 'selected' : '' }}>
                                Tercero "No dueño"
                            </option>
<<<<<<< HEAD
                            <option value="insurance" {{ old('client_type') == 'insurance' ? 'selected' : '' }}>
                                Aseguradora
                            </option>
=======
>>>>>>> 964613b02c73302aea2dc33386313b314db28634
                        </select>
                        @error('client_type')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Descripcion</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                    </div>

                </div>

                <div class="card-footer">
                    <a href="{{ route('clients.index') }}" class="btn btn-secondary">
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
