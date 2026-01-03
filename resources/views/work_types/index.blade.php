@extends('layouts.app')

@section('title', 'Work Types')

@section('content')
    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tipos de trabajos</h3>

                <div class="card-tools">
                    <a href="{{ route('work_types.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Nuevo tipo de trabajo
                    </a>
                </div>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($workTypes as $type)
                            <tr>
                                <td>{{ $type->id }}</td>
                                <td>{{ $type->name }}</td>
                                <td>{{ $type->description ?? '—' }}</td>
                                <td>
                                    <a href="{{ route('work_types.show', $type) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ route('work_types.edit', $type) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('work_types.destroy', $type) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')

                                        <button type="button" class="btn btn-danger btn-sm" data-confirm
                                            data-title="¿Eliminar tipo de trabajo?" data-text="El tipo de trabajo se eliminar definitivamente"
                                            data-confirm="Sí, eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    NO hay tipos de trabajos existentes
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                {{ $workTypes->links() }}
            </div>
        </div>

    </div>
@endsection
