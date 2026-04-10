<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Property::latest();

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $properties = $query->paginate(10);
        return view('properties.index', compact('properties'));
    }

    public function create()
    {
        return view('properties.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'type'        => 'required|in:apartment,villa,plot,commercial',
            'status'      => 'required|in:available,sold,rented',
            'price'       => 'required|numeric|min:0',
            'location'    => 'required|string|max:255',
            'area_sqft'   => 'nullable|string',
            'bedrooms'    => 'nullable|integer',
            'bathrooms'   => 'nullable|integer',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('properties', 'public');
        }

        $validated['user_id'] = Auth::id();
        Property::create($validated);

        return redirect()->route('properties.index')
                         ->with('success', 'Property added successfully!');
    }

    public function show(Property $property)
    {
        return view('properties.show', compact('property'));
    }

    public function edit(Property $property)
    {
        return view('properties.edit', compact('property'));
    }

    public function update(Request $request, Property $property)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'type'        => 'required|in:apartment,villa,plot,commercial',
            'status'      => 'required|in:available,sold,rented',
            'price'       => 'required|numeric|min:0',
            'location'    => 'required|string|max:255',
            'area_sqft'   => 'nullable|string',
            'bedrooms'    => 'nullable|integer',
            'bathrooms'   => 'nullable|integer',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($property->image) {
                Storage::disk('public')->delete($property->image);
            }
            $validated['image'] = $request->file('image')->store('properties', 'public');
        }

        $property->update($validated);

        return redirect()->route('properties.index')
                         ->with('success', 'Property updated successfully!');
    }

    public function destroy(Property $property)
    {
        if ($property->image) {
            Storage::disk('public')->delete($property->image);
        }
        $property->delete();

        return redirect()->route('properties.index')
                         ->with('success', 'Property deleted successfully!');
    }
}
