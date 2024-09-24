<?php

namespace App\Http\Controllers;

use App\Imports\ItemsImport;
use App\Models\Item;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::query()
            ->when(FacadesRequest::input('search'), function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy('name', 'asc')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Items/Index', [
            'items' => $items,
            'filters' => FacadesRequest::only(['search'])
        ]);
    }

    public function lowStockIndex()
    {

        $lowStockItems = Item::query()
            ->when(FacadesRequest::input('search'), function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->whereRaw('quantity <= restock_threshold')
            ->orderBy('name', 'asc')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Items/LowStockIndex', [
            'lowStockItems' => $lowStockItems,
            'filters' => FacadesRequest::only(['search'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Items/Create', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:items,name|string',
            'quantity' => 'required|integer|min:1',
            'restock_threshold' => 'required|integer|min:1',
            'lot_no' => 'nullable|string',
        ]);

        $item = Item::create($validated);

        return redirect()->route('items.index')->with('message', "Successfully added {$item->name}");
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        return Inertia::render('Items/Edit', [
            'item' => $item,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        // dd($item->name);
        $validated = $request->validate([
            'name' => ['required', 'string', Rule::unique('items', 'name')->ignore($item->id)],
            'quantity' => 'required|integer|min:0',
            'restock_threshold' => 'required|integer|min:1',
            'lot_no' => 'nullable|string',
        ]);

        $item->update($validated);

        return redirect()->route('items.index');
    }

    public function createImport()
    {
        return Inertia::render('Items/Import', []);
    }

    public function import(Request $request)
    {

        // $validated = $request->validate([
        //     'import_file' => 'required|file|mimes:xls,xlsx|max:2048'
        // ]);
        // Excel::import(new ItemsImport, $validated['import_file']);
        Excel::import(new ItemsImport, 'Inventory.xlsx');
        return 'Success';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        //
    }
}
