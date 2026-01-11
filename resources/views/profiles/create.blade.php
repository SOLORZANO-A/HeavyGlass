@extends('layouts.app')

@section('title', 'Nuevo Perfil')

@section('content')

@php
    $permissionLabels = [
        'manage profiles' => 'Gestionar perfiles',
        'manage clients' => 'Gestionar clientes',
        'manage vehicles' => 'Gestionar vehículos',
        'manage intake sheets' => 'Gestionar hojas de ingreso',
        'manage work orders' => 'Gestionar órdenes de trabajo',
        'manage proformas' => 'Gestionar proformas',
        'manage payments' => 'Gestionar pagos',
    ];

    $roleLabels = [
        'admin' => 'Administrador',
        'advisor' => 'Asesor',
        'cashier' => 'Cajero/a',
        'workshop_boss' => 'Jefe de Taller',
        'workshop_manager' => 'Jefe de Taller'
    ];
@endphp

<div class="container-fluid">

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Crear Nuevo Perfil</h3>
        </div>

        <form action="{{ route('profiles.store') }}" method="POST">
            @csrf

            <div class="card-body">

                {{-- ================= INFORMACIÓN PERSONAL ================= --}}
                <h5 class="mb-3">Información Personal</h5>

                <div class="row">
                    <div class="col-md-6">
                        <label>Primer nombre</label>
                        <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label>Apellido</label>
                        <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" required>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-4">
                        <label>Cédula de Identidad</label>
                        <input type="text" name="document" class="form-control" value="{{ old('document') }}">
                    </div>

                    <div class="col-md-4">
                        <label>Teléfono</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                    </div>

                    <div class="col-md-4">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                        <small class="text-muted">Requerido para el acceso al sistema</small>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <label>Dirección</label>
                        <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                    </div>

                    <div class="col-md-6">
                        <label>Descripción</label>
                        <input type="text" name="description" class="form-control" value="{{ old('description') }}">
                    </div>
                </div>

                <hr>

                {{-- ================= INFORMACIÓN DEL PERSONAL ================= --}}
                <h5 class="mb-3">Información del Personal</h5>

                <div class="row">
                    <div class="col-md-6">
                        <label>Tipo de Personal</label>
                        <select name="staff_type" class="form-control" required>
                            <option value="">-- Seleccione --</option>
                            <option value="technician">Técnico</option>
                            <option value="advisor">Asesor</option>
                            <option value="cashier">Cajero/a</option>
                            <option value="workshop_manager">Jefe de Taller</option>
                            <option value="admin">Administrador</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Especialización</label>
                        <input type="text" name="specialization" class="form-control">
                    </div>
                </div>

                <hr>

                {{-- ================= ACCESO AL SISTEMA ================= --}}
                <h5 class="mb-3">Acceso al Sistema</h5>

                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="create_user" name="create_user" value="1">
                    <label class="form-check-label" for="create_user">
                        Este perfil tiene acceso al sistema
                    </label>
                </div>

                <div class="form-group">
                    <label>Rol en el Sistema</label>
                    <select name="role" id="role_select" class="form-control">
                        <option value="">-- Seleccione Rol --</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}">
                                {{ $roleLabels[$role->name] ?? ucfirst(str_replace('_', ' ', $role->name)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- ================= PERMISOS SOLO ADMIN ================= --}}
                <div id="permissions_box" class="card card-outline card-danger mt-3" style="display:none;">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fas fa-shield-alt"></i> Permisos del Administrador
                        </h5>
                    </div>

                    <div class="card-body">
                        <p class="text-muted">
                            Asigne solo los permisos necesarios.
                            <strong>Un uso incorrecto puede comprometer el sistema.</strong>
                        </p>

                        @foreach ($permissionLabels as $permission => $label)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                       name="permissions[]"
                                       value="{{ $permission }}"
                                       id="perm_{{ Str::slug($permission) }}">
                                <label class="form-check-label" for="perm_{{ Str::slug($permission) }}">
                                    {{ $label }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <hr>

                <div class="form-group">
                    <label>Contraseña</label>
                    <input type="password" name="password" class="form-control" placeholder="Mínimo 6 caracteres">
                </div>

                <div class="form-group">
                    <label>Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>

            </div>

            <div class="card-footer">
                <a href="{{ route('profiles.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Crear Perfil</button>
            </div>

        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const roleSelect = document.getElementById('role_select');
    const permissionsBox = document.getElementById('permissions_box');

    function togglePermissions() {
        if (roleSelect.value === 'admin') {
            permissionsBox.style.display = 'block';
        } else {
            permissionsBox.style.display = 'none';
            permissionsBox.querySelectorAll('input[type=checkbox]').forEach(cb => cb.checked = false);
        }
    }

    roleSelect.addEventListener('change', togglePermissions);
});
</script>
@endpush
