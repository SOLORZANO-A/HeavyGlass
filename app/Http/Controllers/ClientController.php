<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::latest()->paginate(10);
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'first_name'   => 'required|string|max:255',
        'last_name'    => 'required|string|max:255',
        'document'     => 'required|string|unique:clients,document',
        'phone'        => 'nullable|string',
        'email'        => 'nullable|email',
        'address'      => 'nullable|string',
        'client_type'  => 'required|in:owner,third,insurance',
        'description'  => 'nullable|string',
        'id_copy'      => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    // 1️⃣ Crear cliente
    $client = Client::create($data);

    // 2️⃣ Guardar archivo si existe
    if ($request->hasFile('id_copy')) {
        $path = $request->file('id_copy')->store('clients/ids', 'public');

        $client->update([
            'id_copy_path' => $path,
        ]);
    }

    return redirect()
        ->route('clients.index')
        ->with('success', 'Cliente creado correctamente');
}



    public function show(Client $client)
    {
        return view('clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
{
    $data = $request->validate([
        'first_name'   => 'required|string|max:255',
        'last_name'    => 'required|string|max:255',
        'document'     => 'required|string|unique:clients,document,' . $client->id,
        'phone'        => 'nullable|string',
        'email'        => 'nullable|email',
        'address'      => 'nullable|string',
        'client_type'  => 'required|in:owner,third,insurance',
        'description'  => 'nullable|string',
        'id_copy'      => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    // 1️⃣ Actualizar datos
    $client->update($data);

    // 2️⃣ Nuevo archivo
    if ($request->hasFile('id_copy')) {

        // eliminar archivo anterior
        if ($client->id_copy_path) {
            \Storage::disk('public')->delete($client->id_copy_path);
        }

        $path = $request->file('id_copy')->store('clients/ids', 'public');

        $client->update([
            'id_copy_path' => $path,
        ]);
    }

    return redirect()
        ->route('clients.index')
        ->with('success', 'Cliente actualizado correctamente');
}



    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client deleted successfully');
    }
}
