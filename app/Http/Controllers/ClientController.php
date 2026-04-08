<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Client::latest();

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $clients = $query->paginate(10);
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:clients',
            'phone'   => 'required|string|max:20',
            'type'    => 'required|in:buyer,seller,tenant',
            'address' => 'nullable|string',
            'notes'   => 'nullable|string',
        ]);

        Client::create($validated);

        return redirect()->route('clients.index')
                         ->with('success', 'Client added successfully!');
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
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:clients,email,' . $client->id,
            'phone'   => 'required|string|max:20',
            'type'    => 'required|in:buyer,seller,tenant',
            'address' => 'nullable|string',
            'notes'   => 'nullable|string',
        ]);

        $client->update($validated);

        return redirect()->route('clients.index')
                         ->with('success', 'Client updated successfully!');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index')
                         ->with('success', 'Client deleted successfully!');
    }
}
