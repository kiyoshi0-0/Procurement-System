<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\PurchaseRequest;
use Illuminate\Http\Request;

class PurchaseRequestController extends Controller
{
    // Idagdag mo itong function na ito
    public function showAllRequests()
    {
        // 1. Kunin ang lahat ng data mula sa database
        $requests = PurchaseRequest::all();
        $totalCount = $requests->count();
        $pendingCount = $requests->where('status', 'Pending')->count();

        // 2. I-return ang view (siguraduhin na may file ka na resources/views/all_requests.blade.php)
        return view('requests.main', compact('requests', 'totalCount', 'pendingCount'));
    }

    public function store(Request $request)
{
    
    // Dito nakalista ang lahat ng 'name' attributes mula sa form mo
        $request->validate([
        'emp_name'      => 'required|string|max:255',
        'emp_dept'      => 'required|string',
        'priority'      => 'required|string',
        'justification' => 'required|string',
        
        // Dagdag para sa items (yung dynamic fields natin)
        'items.name'     => 'required|array',
        'items.brand'    => 'required|array',
        'items.category' => 'required|array',
        'items.qty'      => 'required|array',
        'items.price'    => 'required|array',
    ]);

        // 2. Loop sa items at i-save
        $createdCount = 0;

        foreach ($request->items['name'] as $index => $name) {
            PurchaseRequest::create([
                'requestor'     => $request->input('emp_name'), 
                'dept'          => $request->input('emp_dept'),
                'priority'      => $request->input('priority'),
                'justification' => $request->input('justification'), // Siguraduhin na ito ang tamang name sa HTML
                'status'        => 'Pending', // Default value

                'item_name'     => $request->items['name'][$index],
                'category'      => $request->items['category'][$index],
                'brand'         => $request->items['brand'][$index],
                'qty'           => $request->items['qty'][$index],
                'price'         => $request->items['price'][$index],
            ]);
            $createdCount++;
        }

        ActivityLog::create([
            'po_number' => 'Requestor: ' . $request->input('emp_name'),
            'activity'  => 'Request Created',
            'details'   => "Created purchase request for {$request->input('emp_name')} ({$request->input('emp_dept')}) with {$createdCount} item(s).",
            'user_name' => auth()->check() ? auth()->user()->name : 'Admin',
        ]);

        return redirect()->back()->with('success', 'Request saved!');
    }

    public function destroy($id)
    {
        // Hanapin ang record at burahin
        $request = PurchaseRequest::find($id);
        
        if ($request) {
            $request->delete();

            ActivityLog::create([
                'po_number' => 'Request #' . $id,
                'activity'  => 'Request Deleted',
                'details'   => "Deleted purchase request #{$id}.",
                'user_name' => auth()->check() ? auth()->user()->name : 'Admin',
            ]);

            return redirect()->back()->with('success', 'Request deleted successfully!');
        }

        return redirect()->back()->with('error', 'Request not found.');
    }


public function showApprovedRequests()
{
    // CHANGE THIS: Only get the Approved records
    $requests = PurchaseRequest::whereIn('status', ['approved', 'Approved'])->get();
    
    // The rest stays the same for your counters
    $allCount      = PurchaseRequest::count();
    $pendingCount  = PurchaseRequest::whereIn('status', ['pending', 'Pending'])->count();
    $approvedCount = $requests->count(); // This is correct now
    $revisionCount = PurchaseRequest::whereIn('status', ['revision', 'Revision'])->count();
    $rejectedCount = PurchaseRequest::whereIn('status', ['rejected', 'Rejected'])->count();
    
    return view('requests.approved', compact(
        'requests', 'allCount', 'pendingCount', 'approvedCount', 'revisionCount', 'rejectedCount'
    ));
}


                public function showRejectedRequests()
                {
                    // CHANGE THIS: Filter by 'Rejected'
                    $requests = PurchaseRequest::whereIn('status', ['rejected', 'Rejected'])->get();
                    
                    $allCount      = PurchaseRequest::count();
                    $pendingCount  = PurchaseRequest::whereIn('status', ['pending', 'Pending'])->count();
                    $approvedCount = PurchaseRequest::whereIn('status', ['approved', 'Approved'])->count();
                    $revisionCount = PurchaseRequest::whereIn('status', ['revision', 'Revision'])->count();
                    $rejectedCount = $requests->count(); // This now correctly counts only rejected
                    
                    return view('requests.rejected', compact(
                        'requests', 'allCount', 'pendingCount', 'approvedCount', 'revisionCount', 'rejectedCount'
                    ));
}


            public function showRevisionRequests()
            {
                // CHANGE THIS: Filter by 'Revision'
                $requests = PurchaseRequest::whereIn('status', ['revision', 'Revision'])->get();
                
                $allCount      = PurchaseRequest::count();
                $pendingCount  = PurchaseRequest::whereIn('status', ['pending', 'Pending'])->count();
                $approvedCount = PurchaseRequest::whereIn('status', ['approved', 'Approved'])->count();
                $revisionCount = $requests->count(); // This now correctly counts only revision
                $rejectedCount = PurchaseRequest::whereIn('status', ['rejected', 'Rejected'])->count();
                
                return view('requests.revision', compact(
                    'requests', 'allCount', 'pendingCount', 'approvedCount', 'revisionCount', 'rejectedCount'
                ));
            }


        public function showPendingRequests()
        {
            // Filter para PENDING status lamang ang makuha
            $requests = PurchaseRequest::whereIn('status', ['pending', 'Pending'])->get();
            
            // Para sa mga counter sa cards/sidebar
            $allRequests   = PurchaseRequest::all();
            $allCount      = $allRequests->count();
            $pendingCount  = $requests->count();
            $approvedCount = $allRequests->whereIn('status', ['approved', 'Approved'])->count();
            $revisionCount = $allRequests->whereIn('status', ['revision', 'Revision'])->count();
            $rejectedCount = $allRequests->whereIn('status', ['rejected', 'Rejected'])->count();
            
            return view('requests.pending', compact(
                'requests', 
                'allCount', 
                'pendingCount', 
                'approvedCount', 
                'revisionCount', 
                'rejectedCount'
            ));
        }


        public function updateStatus(Request $request, $id) 
    {
        $pr = PurchaseRequest::find($id);
        
        if (!$pr) {
            return response()->json(['success' => false, 'message' => 'Record not found'], 404);
        }

        $pr->status = $request->status;
        $pr->manager_comment = $request->comment;
        $pr->save();

        ActivityLog::create([
            'po_number' => 'Request #' . $id,
            'activity'  => 'Request Status Updated',
            'details'   => "Request #{$id} status changed to {$request->status}. Comment: {$request->comment}",
            'user_name' => auth()->check() ? auth()->user()->name : 'Admin',
        ]);

        return response()->json(['success' => true]);
    }

}