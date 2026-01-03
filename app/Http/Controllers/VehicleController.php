<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Client;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::with('client')
            ->latest()
            ->paginate(10);

        return view('vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        $clients = Client::orderBy('first_name')->get();
        return view('vehicles.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'brand'     => 'required|string|max:255',
            'model'     => 'required|string|max:255',
            'plate'     => 'required|string|unique:vehicles,plate',
            'color'     => 'nullable|string|max:50',
            'year'      => 'nullable|string|max:10',
            'vin'       => 'nullable|string|max:50',
            'chassis'   => 'nullable|string|max:50',
            'engine'    => 'nullable|string|max:50',
            'mileage'   => 'nullable|integer|min:0',
            'description' => 'nullable|string',
        ]);

        Vehicle::create($data);

        return redirect()
            ->route('vehicles.index')
            ->with('success', 'Vehicle created successfully');
    }

    public function show(Vehicle $vehicle)
    {
        $vehicle->load('client');

        return view('vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        $clients = Client::orderBy('first_name')->get();

        return view('vehicles.edit', compact('vehicle', 'clients'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $data = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'brand'     => 'required|string|max:255',
            'model'     => 'required|string|max:255',
            'plate'     => 'required|string|unique:vehicles,plate,' . $vehicle->id,
            'color'     => 'nullable|string|max:50',
            'year'      => 'nullable|string|max:10',
            'vin'       => 'nullable|string|max:50',
            'chassis'   => 'nullable|string|max:50',
            'engine'    => 'nullable|string|max:50',
            'mileage'   => 'nullable|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $vehicle->update($data);

        return redirect()
            ->route('vehicles.index')
            ->with('success', 'Vehicle updated successfully');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return redirect()
            ->route('vehicles.index')
            ->with('success', 'Vehicle deleted successfully');
    }
}
