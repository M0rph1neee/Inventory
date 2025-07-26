<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use PDO;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //  Index Filtering

        $query = Inventory::query();

        // Filtering by item_name (search box)
        if ($request->filled('search')) {
            $query->where('item_name', 'like', '%' . $request->search . '%');
        }

        // Filtering by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filtering by location
        if ($request->filled('location')) {
            $query->where('location', $request->location);
        }

        // Filtering by buy_method
        if ($request->filled('buy_method')) {
            $query->where('buy_method', $request->buy_method);
        }

        // Filtering by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Retrieve all inventory items
        $inventories = $query->latest()->get();
        return view('inventory.index', compact('inventories'));
    }

    public function create()
    {
        $types = Inventory::distinct()->pluck('type');
        $locations = Inventory::distinct()->pluck('location');
        $buyMethods = Inventory::distinct()->pluck('buy_method');
        $categories = Inventory::distinct()->pluck('category');
        return view('inventory.create', compact('types', 'locations', 'buyMethods', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required',
            'quantity' => 'required|integer|min:1',
            'type' => 'required',
            'location' => 'required',
            'buy_method' => 'required',
            'category' => 'required',
            'buy_date' => 'required|date',
        ]);

        Inventory::create($request->all());
        return redirect()->route('inventory.index')->with('success', 'Item added successfully.');
    }

    public function edit($id)
    {
        $types = Inventory::distinct()->pluck('type');
        $locations = Inventory::distinct()->pluck('location');
        $buyMethods = Inventory::distinct()->pluck('buy_method');
        $categories = Inventory::distinct()->pluck('category');
        $item = Inventory::findOrFail($id);
        return view('inventory.edit', compact( 'types', 'locations', 'buyMethods', 'categories','item'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'item_name' => 'required',
            'quantity' => 'required|integer|min:1',
            'type' => 'required',
            'location' => 'required',
            'buy_method' => 'required',
            'category' => 'required',
            'buy_date' => 'required|date',
        ]);

        $item = Inventory::findOrFail($id);
        $item->update($request->all());
        return redirect()->route('inventory.index')->with('success', 'Item updated successfully.');
    }

    public function destroy($id)
    {
        $item = Inventory::findOrFail($id);
        $item->delete();
        return redirect()->route('inventory.index')->with('success', 'Item deleted successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    // 
}
