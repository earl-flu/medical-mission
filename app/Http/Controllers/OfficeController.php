<?php

namespace App\Http\Controllers;

use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Inertia\Inertia;

class OfficeController extends Controller
{
    // Display the list of offices
    public function index()
    {
        $offices = Office::query()
            ->when(FacadesRequest::input('search'), function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy('name', 'asc')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Office/Index', [
            'offices' => $offices,
            'filters' => FacadesRequest::only(['search'])
        ]);
    }

    // Show the form for creating a new office
    public function create()
    {
        return Inertia::render('Office/Create', []);
    }

    // Store a newly created office
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'abbreviation' => 'required|string|max:10',
            'is_active' => 'required|boolean',
        ]);

        Office::create($validated);

        return redirect()->route('offices.index')->with('success', 'Office added successfully.');
    }

    // Show the form for editing an office
    public function edit($id)
    {
        $office = Office::findOrFail($id);
        return Inertia::render('Office/Edit', ['office' => $office]);
    }

    // Update an existing office
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'abbreviation' => 'required|string|max:10',
            'is_active' => 'required|boolean',
        ]);

        $office = Office::findOrFail($id);
        $office->update($validated);

        return redirect()->route('offices.index')->with('success', 'Office updated successfully.');
    }

    // Delete an office
    public function destroy($id)
    {
        $office = Office::findOrFail($id);
        $office->delete();

        return redirect()->route('offices.index')->with('success', 'Office deleted successfully.');
    }
}
