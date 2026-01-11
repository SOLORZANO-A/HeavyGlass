@extends('layouts.app')

@section('title', 'Perfiles')

@section('content')

<<<<<<< HEAD
    @php
        // Traducciones visibles
        $staffTypeLabels = [
            'technician' => 'Técnico',
            'advisor' => 'Asesor',
            'cashier' => 'Cajero/a',
            'workshop_boss' => 'Jefe de Taller',
            'admin' => 'Administrador',
        ];

        $roleLabels = [
            'admin' => 'Administrador',
            'advisor' => 'Asesor',
            'cashier' => 'Cajero/a',
            'workshop_manager' => 'Jefe de Taller',
        ];
    @endphp



    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-users-cog"></i> Personal y Técnicos
                </h3>
            </div>

            <div class="row mb-3 align-items-center">

                <!-- Buscador -->
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control" placeholder="Buscar por nombre o especialidad..."
                            data-table-filter="profiles-table">
                    </div>
                </div>

                <!-- Botón (con permiso) -->
                <div class="col-md-4 text-end">
                    @can('manage users')
                        <a href="{{ route('profiles.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> Nuevo Perfil
                        </a>
                    @endcan
                </div>

            </div>


            <div class="card-body table-responsive p-0">
                <table id="profiles-table" class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre completo</th>
                            <th>Tipo de personal</th>
                            <th>Especialización</th>
                            <th>Usuario del sistema</th>
                            <th>Rol en el sistema</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($profiles as $profile)
                            <tr>
                                <td>{{ $profile->id }}</td>

                                {{-- NOMBRE --}}
                                <td>{{ $profile->fullName() }}</td>

                                {{-- TIPO DE PERSONAL --}}
                                <td>
                                    <span class="badge badge-info">
                                        {{ $staffTypeLabels[$profile->staff_type] ?? ucfirst($profile->staff_type) }}
                                    </span>
                                </td>

                                {{-- ESPECIALIZACIÓN --}}
                                <td>{{ $profile->specialization ?? '—' }}</td>

                                {{-- USUARIO DEL SISTEMA --}}
                                <td>
                                    @if ($profile->user)
                                        <span class="badge badge-success">Sí</span>
                                    @else
                                        <span class="badge badge-secondary">No</span>
                                    @endif
                                </td>

                                {{-- ROL EN EL SISTEMA --}}
                                <td>
                                    @if ($profile->user && $profile->user->getRoleNames()->isNotEmpty())
                                        @php
                                            $roleName = $profile->user->getRoleNames()->first();
                                        @endphp
                                        <span class="badge badge-primary">
                                            {{ $roleLabels[$roleName] ?? ucfirst(str_replace('_', ' ', $roleName)) }}
                                        </span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>

                                {{-- OPCIONES --}}
                                <td>
                                    <a href="{{ route('profiles.show', $profile) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    @can('manage users')
                                        <a href="{{ route('profiles.edit', $profile) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('profiles.destroy', $profile) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')

                                            <button type="button" class="btn btn-danger btn-sm" data-confirm
                                                data-title="¿Eliminar perfil?"
                                                data-text="El perfil se eliminara definitivamente" data-confirm="Sí, eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    No hay perfiles registrados
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                {{ $profiles->links() }}
            </div>
        </div>

    </div>
=======
@php
    // Traducciones visibles
    $staffTypeLabels = [
        'technician'        => 'Técnico',
        'advisor'           => 'Asesor',
        'cashier'           => 'Cajero/a',
        'workshop_boss'  => 'Jefe de Taller',
        'admin'             => 'Administrador',
    ];

    $roleLabels = [
        'admin'            => 'Administrador',
        'advisor'          => 'Asesor',
        'cashier'          => 'Cajero/a',
        'workshop_manager' => 'Jefe de Taller',
    ];
@endphp



<div class="container-fluid">

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Personal y Técnicos</h3>

            @can('manage users')
                <div class="card-tools">
                    <a href="{{ route('profiles.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Nuevo perfil
                    </a>
                </div>
            @endcan
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre completo</th>
                        <th>Tipo de personal</th>
                        <th>Especialización</th>
                        <th>Usuario del sistema</th>
                        <th>Rol en el sistema</th>
                        <th>Opciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($profiles as $profile)
                        <tr>
                            <td>{{ $profile->id }}</td>

                            {{-- NOMBRE --}}
                            <td>{{ $profile->fullName() }}</td>

                            {{-- TIPO DE PERSONAL --}}
                            <td>
                                <span class="badge badge-info">
                                    {{ $staffTypeLabels[$profile->staff_type] ?? ucfirst($profile->staff_type) }}
                                </span>
                            </td>

                            {{-- ESPECIALIZACIÓN --}}
                            <td>{{ $profile->specialization ?? '—' }}</td>

                            {{-- USUARIO DEL SISTEMA --}}
                            <td>
                                @if ($profile->user)
                                    <span class="badge badge-success">Sí</span>
                                @else
                                    <span class="badge badge-secondary">No</span>
                                @endif
                            </td>

                            {{-- ROL EN EL SISTEMA --}}
                            <td>
                                @if ($profile->user && $profile->user->getRoleNames()->isNotEmpty())
                                    @php
                                        $roleName = $profile->user->getRoleNames()->first();
                                    @endphp
                                    <span class="badge badge-primary">
                                        {{ $roleLabels[$roleName] ?? ucfirst(str_replace('_', ' ', $roleName)) }}
                                    </span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>

                            {{-- OPCIONES --}}
                            <td>
                                <a href="{{ route('profiles.show', $profile) }}"
                                   class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>

                                @can('manage users')
                                    <a href="{{ route('profiles.edit', $profile) }}"
                                       class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('profiles.destroy', $profile) }}"
                                          method="POST"
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')

                                        <button type="button" class="btn btn-danger btn-sm" data-confirm
                                            data-title="¿Eliminar perfil?" data-text="El perfil se eliminara definitivamente"
                                            data-confirm="Sí, eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                No hay perfiles registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer clearfix">
            {{ $profiles->links() }}
        </div>
    </div>

</div>
>>>>>>> 964613b02c73302aea2dc33386313b314db28634
@endsection
