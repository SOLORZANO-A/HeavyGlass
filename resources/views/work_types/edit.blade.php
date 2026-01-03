@extends('layouts.app')

@section('title', 'Edit Work Type')

@section('content')
<div class="container-fluid">

    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">Editar tipo de trabajo</h3>
        </div>

        <form action="{{ route('work_types.update', $workType) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">

                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text"
                           name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $workType->name) }}">
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Descripcion</label>
                    <textarea name="description"
                              class="form-control"
                              rows="3">{{ old('description', $workType->description) }}</textarea>
                </div>

            </div>

            <div class="card-footer">
                <a href="{{ route('work_types.show', $workType) }}" class="btn btn-secondary">
                    Cancelar
                </a>

                <button type="submit" class="btn btn-warning">
                    Actualizar
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
