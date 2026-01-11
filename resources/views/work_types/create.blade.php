@extends('layouts.app')

@section('title', 'Nuevo tipo de trabajo')

@section('content')
<div class="container-fluid">

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Crea un Tipo de trabajo</h3>
        </div>

        <form action="{{ route('work_types.store') }}" method="POST">
            @csrf

            <div class="card-body">

                {{-- Name --}}
                <div class="form-group">
                    <label>Nombre del tipo de trabajo</label>
                    <input type="text"
                           name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}"
                           placeholder="Ejemplo: Pintura, Chapisteria, Enderezada">

                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="form-group">
                    <label>Descripción (opcional)</label>
                    <textarea name="description"
                              class="form-control @error('description') is-invalid @enderror"
                              rows="3"
                              placeholder="Opcional describe el tipo de trabajo">{{ old('description') }}</textarea>

                    @error('description')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            <div class="card-footer">
                <a href="{{ route('work_types.index') }}" class="btn btn-secondary">
                    Cancelar
                </a>

                <button type="submit" class="btn btn-primary">
                    Guardar tipo de trabajo
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
