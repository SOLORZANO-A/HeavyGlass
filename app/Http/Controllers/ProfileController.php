<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ProfileController extends Controller
{
    /**
     * UI → ENUM BD (NO tocar la BD)
     */
    private array $staffTypeMap = [
        'technician'        => 'technician',
        'advisor'           => 'advisor',
        'cashier'           => 'cashier',
        'workshop_manager'  => 'workshop_boss',
        'admin'             => 'admin',
    ];

    /* ============================================================
     * LISTADO
     * ============================================================
     */
    public function index()
    {
        $profiles = Profile::with('user')
            ->orderBy('first_name')
            ->paginate(10);

        return view('profiles.index', compact('profiles'));
    }

    /* ============================================================
     * CREATE
     * ============================================================
     */
    public function create()
    {
        $roles = Role::orderBy('name')->get();
        $permissions = Permission::orderBy('name')->get();

        return view('profiles.create', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            // Datos personales
            'first_name'     => 'required|string|max:100',
            'last_name'      => 'required|string|max:100',
            'document'       => 'nullable|string|max:50',
            'email'          => 'nullable|email',
            'phone'          => 'nullable|string|max:20',
            'address'        => 'nullable|string|max:255',
            'description'    => 'nullable|string|max:255',

            // Personal
            'staff_type'     => 'required|in:technician,advisor,cashier,workshop_manager,admin',
            'specialization' => 'nullable|string|max:100',

            // Sistema
            'create_user'    => 'nullable|boolean',
            'role'           => 'nullable|exists:roles,name',
            'permissions'    => 'nullable|array',
            'permissions.*'  => 'exists:permissions,name',
            'password'       => 'nullable|confirmed|min:6',
        ]);

        // Mapear staff_type (UI → BD)
        $staffType = $this->staffTypeMap[$data['staff_type']] ?? abort(400, 'Tipo de personal inválido');

        // Crear perfil
        $profile = Profile::create([
            'first_name'     => $data['first_name'],
            'last_name'      => $data['last_name'],
            'document'       => $data['document'] ?? null,
            'email'          => $data['email'] ?? null,
            'phone'          => $data['phone'] ?? null,
            'address'        => $data['address'] ?? null,
            'description'    => $data['description'] ?? null,
            'staff_type'     => $staffType,
            'specialization' => $data['specialization'] ?? null,
        ]);

        // Crear usuario del sistema
        if ($request->filled('create_user')) {

            if (empty($data['email'])) {
                return back()
                    ->withErrors(['email' => 'El email es obligatorio para el acceso al sistema'])
                    ->withInput();
            }

            $user = User::create([
                'name'     => $profile->fullName(),
                'email'    => $data['email'],
                'password' => Hash::make($data['password'] ?? 'password123'),
            ]);

            if (!empty($data['role'])) {
                $user->assignRole($data['role']);
            }

            if (!empty($data['permissions'])) {
                $user->syncPermissions($data['permissions']);
            }

            $profile->update(['user_id' => $user->id]);
        }

        return redirect()
            ->route('profiles.index')
            ->with('success', 'Perfil creado correctamente');
    }

    /* ============================================================
     * EDIT
     * ============================================================
     */
    public function edit(Profile $profile)
    {
        $roles = Role::orderBy('name')->get();
        $permissions = Permission::orderBy('name')->get();

        return view('profiles.edit', compact('profile', 'roles', 'permissions'));
    }

    /* ============================================================
     * UPDATE
     * ============================================================
     */
    public function update(Request $request, Profile $profile)
    {
        $data = $request->validate([
            // Datos personales
            'first_name'     => 'required|string|max:100',
            'last_name'      => 'required|string|max:100',
            'document'       => 'nullable|string|max:50',
            'email'          => 'nullable|email',
            'phone'          => 'nullable|string|max:20',
            'address'        => 'nullable|string|max:255',
            'description'    => 'nullable|string|max:255',

            // Personal
            'staff_type'     => 'required|in:technician,advisor,cashier,workshop_manager,admin',
            'specialization' => 'nullable|string|max:100',

            // Sistema
            'create_user'    => 'nullable|boolean',
            'role'           => 'nullable|exists:roles,name',
            'permissions'    => 'nullable|array',
            'permissions.*'  => 'exists:permissions,name',
            'password'       => 'nullable|confirmed|min:6',
        ]);

        // Mapear staff_type
        $staffType = $this->staffTypeMap[$data['staff_type']] ?? abort(400, 'Tipo de personal inválido');

        // Actualizar perfil
        $profile->update([
            'first_name'     => $data['first_name'],
            'last_name'      => $data['last_name'],
            'document'       => $data['document'] ?? null,
            'email'          => $data['email'] ?? null,
            'phone'          => $data['phone'] ?? null,
            'address'        => $data['address'] ?? null,
            'description'    => $data['description'] ?? null,
            'staff_type'     => $staffType,
            'specialization' => $data['specialization'] ?? null,
        ]);

        // Acceso al sistema
        if ($request->filled('create_user')) {

            if (empty($data['email'])) {
                return back()
                    ->withErrors(['email' => 'El email es obligatorio para el acceso al sistema'])
                    ->withInput();
            }

            if (!$profile->user) {
                $user = User::create([
                    'name'     => $profile->fullName(),
                    'email'    => $data['email'],
                    'password' => Hash::make($data['password'] ?? 'password123'),
                ]);

                $profile->update(['user_id' => $user->id]);
            } else {
                $user = $profile->user;

                if ($user->email !== $data['email']) {
                    $user->update(['email' => $data['email']]);
                }
            }

            // Cambiar contraseña si se envía
            if (!empty($data['password'])) {
                $user->update([
                    'password' => Hash::make($data['password'])
                ]);
            }

            // Rol
            if (!empty($data['role'])) {
                $user->syncRoles([$data['role']]);
            }

            // Permisos (solo admin)
            $user->syncPermissions($data['permissions'] ?? []);
        } else {
            // Quitar acceso al sistema
            if ($profile->user) {
                $profile->user->delete();
                $profile->update(['user_id' => null]);
            }
        }

        return redirect()
            ->route('profiles.index')
            ->with('success', 'Perfil actualizado correctamente');
    }
    public function show(Profile $profile)
{
    return view('profiles.show', compact('profile'));
}


    /* ============================================================
     * DESTROY
     * ============================================================
     */
    public function destroy(Profile $profile)
    {
        if ($profile->user) {
            $profile->user->delete();
        }

        $profile->delete();

        return redirect()
            ->route('profiles.index')
            ->with('success', 'Perfil eliminado correctamente');
    }
}
