@extends('layouts.app')

@section('title', 'Detalle del Perfil')

@section('content')

@php
    $staffTypeLabels = [
        'technician'        => 'Técnico',
        'advisor'           => 'Asesor',
        'cashier'           => 'Cajero/a',
        'workshop_manager'  => 'Jefe de Taller',
        'admin'             => 'Administrador',
    ];
@endphp

<div class="container-fluid">

    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Información del Perfil</h3>

            <div class="card-tools">
                @can('manage users')
                    <a href="{{ route('profiles.edit', $profile) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                @endcan

                <a href="{{ route('profiles.index') }}" class="btn btn-secondary btn-sm">
                    Atrás
                </a>
            </div>
        </div>

        <div class="card-body">

            {{-- INFORMACIÓN PERSONAL --}}
            <h5 class="mb-3">Información Personal</h5>

            <table class="table table-bordered">
                <tr>
                    <th width="220">Nombre Completo</th>
                    <td>{{ $profile->fullName() }}</td>
                </tr>
                <tr>
                    <th>Cédula de identidad</th>
                    <td>{{ $profile->document }}</td>
                </tr>
                <tr>
                    <th>Teléfono</th>
                    <td>{{ $profile->phone ?? '—' }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $profile->email ?? '—' }}</td>
                </tr>
                <tr>
                    <th>Dirección</th>
                    <td>{{ $profile->address ?? '—' }}</td>
                </tr>
                <tr>
                    <th>Descripción</th>
                    <td>{{ $profile->description ?? '—' }}</td>
                </tr>
            </table>

            <hr>

            {{-- INFORMACIÓN DEL PERSONAL --}}
            <h5 class="mb-3">Información del Personal</h5>

            <table class="table table-bordered">
                <tr>
                    <th width="220">Tipo de Personal</th>
                    <td>
                        <span class="badge badge-info">
                            {{ $staffTypeLabels[$profile->staff_type] ?? ucfirst($profile->staff_type) }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Especialización</th>
                    <td>{{ $profile->specialization ?? '—' }}</td>
                </tr>
            </table>

            <hr>

            {{-- ACCESO AL SISTEMA --}}
            <h5 class="mb-3">Acceso al Sistema</h5>

            <table class="table table-bordered">
                <tr>
                    <th width="220">Usuario del Sistema</th>
                    <td>
                        @if ($profile->user)
                            <span class="badge badge-success">Sí</span>
                        @else
                            <span class="badge badge-secondary">No</span>
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Rol en el Sistema</th>
                    <td>
                        @if ($profile->user && $profile->user->getRoleNames()->isNotEmpty())
                            <span class="badge badge-primary">
                                {{ ucfirst(str_replace('_', ' ', $profile->user->getRoleNames()->first())) }}
                            </span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                </tr>
            </table>

            <hr>

            {{-- FECHAS --}}
            <h5 class="mb-3">Información del Registro</h5>

            <table class="table table-bordered">
                <tr>
                    <th width="220">Fecha de Creación</th>
                    <td>{{ $profile->created_at->format('Y-m-d H:i') }}</td>
                </tr>
                <tr>
                    <th>Última Actualización</th>
                    <td>{{ $profile->updated_at->format('Y-m-d H:i') }}</td>
                </tr>
            </table>

        </div>

        <div class="card-footer">
            <a href="{{ route('profiles.index') }}" class="btn btn-secondary">
                Regresar a la Lista
            </a>
        </div>
    </div>

</div>
@endsection
