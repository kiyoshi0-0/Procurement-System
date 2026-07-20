<?php

namespace App\Http\Controllers;

use App\Models\Supplier; 
use App\Models\Contract; // Ensure this is imported
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        // Start the query builder
        $query = Supplier::orderBy('created_at', 'desc');

        // Apply search filter if present
        if ($request->filled('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        // Paginate results (this keeps the search parameter across pages automatically)
        $suppliers = $query->paginate(10)->withQueryString();

        return view('suppliers.index', compact('suppliers')); 
    }

    public function create()
    {
        return view('suppliers.create'); 
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'sub_categories' => 'nullable|string|max:255',
            'contact_person' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'required|string',
            'payment_terms' => 'nullable|string',
            'delivery_schedule' => 'nullable|string',
        ]);

        Supplier::create($validated);

        return redirect()->route('suppliers.index')->with('success', 'Supplier added successfully!');
    }

    public function show($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('suppliers.show', compact('supplier'));
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'sub_categories' => 'nullable|string|max:255',
            'status' => 'required|string|in:Active,Inactive',
            'contact_person' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'payment_terms' => 'nullable|string',
            'delivery_schedule' => 'nullable|string',
        ]);

        $supplier->update($validated);

        return redirect()->route('suppliers.index')->with('success', 'Supplier updated successfully.');
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return redirect()->route('suppliers.index')->with('success', 'Supplier deleted successfully.');
    }

    public function evaluation($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('suppliers.evaluation', compact('supplier'));
    }

    public function storeEvaluation(Request $request, $id)
    {
        $validated = $request->validate([
            'metrics.delivery' => 'required|integer|min:1|max:5',
            'metrics.quality' => 'required|integer|min:1|max:5',
            'metrics.pricing' => 'required|integer|min:1|max:5',
            'notes' => 'nullable|string',
        ]);

        $ratings = $validated['metrics'];
        $averageRating = array_sum($ratings) / count($ratings);

        $supplier = Supplier::findOrFail($id);
        $supplier->update(['rating' => $averageRating]);

        return redirect()->route('suppliers.show', $id)->with('success', 'Evaluation saved! Average rating: ' . number_format($averageRating, 1));
    }

    public function history() { return view('suppliers.history'); }
    
    // Updated to pass dynamic contract data to the view
    public function contracts(Request $request) 
    { 
        // Initialize query
        $query = \App\Models\Contract::query()->with('supplier');

        // Use whereHas only if a search term exists
        if ($request->filled('search')) {
            $query->whereHas('supplier', function($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search . '%');
            });
        }

        $contracts = $query->get();
        
        return view('suppliers.contracts', compact('contracts')); 
    }

    // In App\Http\Controllers\SupplierController.php
    public function search(Request $request)
    {
        $query = \App\Models\Supplier::query();

        // Search functionality
        if ($request->filled('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        // Existing filters (keep these)
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        
        if ($request->filled('min_rating')) {
            $query->where('rating', '>=', $request->min_rating);
        }

        if ($request->filled('delivery_time')) {
            $query->where('delivery_schedule', $request->delivery_time);
        }

        $suppliers = $query->get();
        $supplierCount = $suppliers->count();
        
        return view('suppliers.search', compact('suppliers', 'supplierCount'));
    }
}