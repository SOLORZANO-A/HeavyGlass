@extends('layouts.app')

@section('title', 'Work Type Details')

@section('content')
<div class="container-fluid">

    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Informacion del tipo de trabajo</h3>

            <div class="card-tools">
                <a href="{{ route('work_types.edit', $workType) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Editar
                </a>

                <a href="{{ route('work_types.index') }}" class="btn btn-secondary btn-sm">
                    Atras
                </a>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="200">Nombre</th>
                    <td>{{ $workType->name }}</td>
                </tr>
                <tr>
                    <th>Descripción</th>
                    <td>{{ $workType->description ?? '—' }}</td>
                </tr>
                <tr>
                    <th>Hora de creación</th>
                    <td>{{ $workType->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            </table>
        </div>

        <div class="card-footer">
            <a href="{{ route('work_types.index') }}" class="btn btn-secondary">
                Regresar a la lista
            </a>
        </div>
    </div>

</div>
@endsection
