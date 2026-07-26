<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeliveryIssue; // <-- Palitan ang Receipt ng DeliveryIssue

class DeliveryIssueController extends Controller
{
    public function index()
    {
        // Kunin lahat ng records mula sa delivery_issues table
        $deliveryIssues = DeliveryIssue::latest()->get();

        return view(
            'receipts.deliveryissues',
            compact('deliveryIssues')
        );
    }
    public function resolve($id)
 {
    $issue = DeliveryIssue::findOrFail($id);
    $issue->status = 'Resolved';
    $issue->save();

    return redirect()->back()->with('success', 'Issue marked as resolved.');
 }
 public function update(Request $request, $id)
{
    $issue = DeliveryIssue::findOrFail($id);
    $issue->supplier = $request->supplier;
    $issue->item_name = $request->item_name;
    $issue->issue_type = $request->issue_type;
    $issue->status = $request->status;
    $issue->save();

    return redirect()->back()->with('success', 'Issue updated successfully.');
}
public function destroy($id)
{
    $issue = DeliveryIssue::findOrFail($id);
    $issue->delete();

    return redirect()->back()->with('success', 'Delivery issue deleted successfully.');


public function store(Request $request)
{
    $request->validate([
        'receipt_id' => 'required|exists:receipts,id',
        'receipt_number' => 'required',
        'supplier' => 'required',
        'item_name' => 'required',
        'issue_type' => 'required',
        'priority' => 'required',
        'status' => 'required',
    ]);

    $issue = new \App\Models\DeliveryIssue();
    $issue->receipt_id = $request->receipt_id;
    $issue->receipt_number = $request->receipt_number;
    $issue->supplier = $request->supplier;
    $issue->item_name = $request->item_name;
    $issue->issue_type = $request->issue_type;
    $issue->priority = $request->priority;
    $issue->status = $request->status;
    $issue->save();

    return redirect()->back()->with('success', 'Delivery issue added successfully.');
}
}