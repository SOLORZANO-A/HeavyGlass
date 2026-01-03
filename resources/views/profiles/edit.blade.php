@extends('layouts.app')

@section('title', 'Editar Perfil')

@section('content')

@php
    $staffTypeLabels = [
        'technician' => 'Técnico',
        'advisor' => 'Asesor',
        'cashier' => 'Cajero/a',
        'workshop_manager' => 'Jefe de Taller',
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
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">Editar Perfil</h3>
        </div>

        <form action="{{ route('profiles.update', $profile) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">

                {{-- ================= INFORMACIÓN PERSONAL ================= --}}
                <h5 class="mb-3">Información Personal</h5>

                <div class="row">
                    <div class="col-md-6">
                        <label>Primer Nombre</label>
                        <input type="text" name="first_name" class="form-control"
                               value="{{ old('first_name', $profile->first_name) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label>Apellido</label>
                        <input type="text" name="last_name" class="form-control"
                               value="{{ old('last_name', $profile->last_name) }}" required>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-4">
                        <label>Cédula de Identidad</label>
                        <input type="text" name="document" class="form-control"
                               value="{{ old('document', $profile->document) }}">
                    </div>

                    <div class="col-md-4">
                        <label>Teléfono</label>
                        <input type="text" name="phone" class="form-control"
                               value="{{ old('phone', $profile->phone) }}">
                    </div>

                    <div class="col-md-4">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control"
                               value="{{ old('email', $profile->email) }}">
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <label>Dirección</label>
                        <input type="text" name="address" class="form-control"
                               value="{{ old('address', $profile->address) }}">
                    </div>

                    <div class="col-md-6">
                        <label>Descripción</label>
                        <input type="text" name="description" class="form-control"
                               value="{{ old('description', $profile->description) }}">
                    </div>
                </div>

                <hr>

                {{-- ================= INFORMACIÓN DEL PERSONAL ================= --}}
                <h5 class="mb-3">Información del Personal</h5>

                <div class="row">
                    <div class="col-md-6">
                        <label>Tipo de Personal</label>
                        <select name="staff_type" class="form-control" required>
                            @foreach ($staffTypeLabels as $value => $label)
                                <option value="{{ $value }}"
                                    {{ old('staff_type', $profile->staff_type) === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Especialización</label>
                        <input type="text" name="specialization" class="form-control"
                               value="{{ old('specialization', $profile->specialization) }}">
                    </div>
                </div>

                <hr>

                {{-- ================= ACCESO AL SISTEMA ================= --}}
                <h5 class="mb-3">Acceso al Sistema</h5>

                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="create_user"
                           name="create_user" value="1"
                           {{ $profile->user ? 'checked' : '' }}>
                    <label class="form-check-label" for="create_user">
                        Este perfil tiene acceso al sistema
                    </label>
                </div>

                <div class="form-group">
                    <label>Rol en el Sistema</label>
                    <select name="role" id="role_select" class="form-control">
                        <option value="">-- Seleccione Rol --</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}"
                                {{ $profile->user && $profile->user->hasRole($role->name) ? 'selected' : '' }}>
                                {{ $roleLabels[$role->name] ?? ucfirst(str_replace('_', ' ', $role->name)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- ================= PERMISOS ADMIN ================= --}}
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

                        <div class="row">
                            @foreach ($permissions as $permission)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                               name="permissions[]"
                                               value="{{ $permission->name }}"
                                               {{ $profile->user && $profile->user->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                        <label class="form-check-label">
                                            {{ ucfirst(str_replace('_', ' ', $permission->name)) }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="alert alert-info mt-3">
                    <i class="fas fa-info-circle"></i>
                    Si no deseas cambiar la contraseña, deja los campos en blanco.
                </div>

                <div class="form-group">
                    <label>Nueva Contraseña</label>
                    <input type="password" name="password" class="form-control"
                           placeholder="Dejar vacío para mantener la actual">
                </div>

                <div class="form-group">
                    <label>Confirmar Nueva Contraseña</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>

            </div>

            <div class="card-footer">
                <a href="{{ route('profiles.index') }}" class="btn btn-secondary">
                    Cancelar
                </a>
                <button type="submit" class="btn btn-warning">
                    Actualizar Perfil
                </button>
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
    togglePermissions(); // al cargar
});
</script>
@endpush
