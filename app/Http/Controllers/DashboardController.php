<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
class DashboardController extends Controller
{

    public function create() {
        return view('dashboard.create');
    }

    public function index()
    {
        // Fetch all records from the orders database table
        $orders = DB::table('orders')->orderBy('created_at', 'desc')->get();

        // Look for the flat file 'order-index.blade.php'
        return view('dashboard.index', compact('orders'));
    }

    public function generate() {
        return view('dashboard.generate');
    }

    // --- FUNCTION 2: HANDLE SAVING NEW ORDERS ---
    public function store(Request $request)
    {
        // 1. Validate the incoming data from your form layout
        $request->validate([
            'supplier_id' => 'required',
            'po_date' => 'required|date',
            'email_address' => 'required|email',
            'items' => 'required|array|min:1',
        ]);

        // 2. Process using a database transaction for complete safety
        DB::transaction(function () use ($request) {
            
            // Insert data into your main orders table
            $orderId = DB::table('orders')->insertGetId([
                'supplier_id' => $request->input('supplier_id'),
                'po_date' => $request->input('po_date'),
                'delivery_date' => $request->input('expected_delivery'),
                'department' => $request->input('department'),
                'requesting_person' => $request->input('requesting_person'),
                'delivery_terms' => $request->input('delivery_terms'),
                'payment_mode' => $request->input('payment_mode'),
                'currency' => $request->input('currency'),
                'email' => $request->input('email_address'),
                'address' => $request->input('address'),
                'notes' => $request->input('notes'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Loop through the indexed items array sent from your JavaScript table rows
            foreach ($request->input('items') as $item) {
                // Extract the row item's identifier name
                $name = $item['name'] ?? ($item['item_name'] ?? null);

                // SKIP saving if the row's item name/field value is completely empty
                if (empty(trim($name))) {
                    continue;
                }

                DB::table('order_items')->insert([
                    'order_id' => $orderId,
                    'item_name' => $name,
                    'category' => $item['category'] ?? null,
                    'unit' => $item['unit'] ?? null,
                    'price' => $item['price'] ?? 0,
                    'quantity' => $item['quantity'] ?? 1,
                ]);
            }
        });

        // 3. Return directly to the orders log page (updated route destination!)
        return redirect('/orders')->with('success', 'Purchase order created successfully!');
    }

    // --- FUNCTION 3: DOWNLOAD ORDER DATA NATIVELY AS A TRUE PDF ---
    public function downloadPDF($id)
    {
        // Fetch order details
        $order = DB::table('orders')->where('id', $id)->first();
        
        if (!$order) {
            return abort(404, 'Purchase order not found.');
        }

        // Fetch all specific individual items matching this sequence identifier
        $items = DB::table('order_items')->where('order_id', $id)->get();

        // Calculate totals dynamically
        $totalAmount = 0;
        foreach ($items as $item) {
            $totalAmount += ($item->price * $item->quantity);
        }

        // Build elegant formal page rendering structure
        $html = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <title>Purchase Order #{$order->id}</title>
            <style>
                body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; margin: 0; padding: 10px; font-size: 12px; line-height: 1.4; }
                .invoice-box { max-width: 100%; margin: auto; }
                .table-header { width: 100%; margin-bottom: 20px; border-collapse: collapse; }
                .title-header { color: #00b074; font-size: 24px; font-weight: bold; }
                .meta-text { text-align: right; font-size: 11px; color: #555; }
                .details-table { width: 100%; margin-bottom: 30px; border-collapse: collapse; }
                .details-table td { width: 50%; vertical-align: top; padding: 4px; }
                .section-title { font-size: 12px; font-weight: bold; color: #00b074; text-transform: uppercase; margin-bottom: 6px; border-bottom: 1px solid #00b074; padding-bottom: 2px; }
                .items-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
                .items-table th { background-color: #f8f9fa; color: #555; font-weight: bold; border-bottom: 2px solid #ddd; padding: 8px; text-align: left; }
                .items-table td { padding: 8px; border-bottom: 1px solid #eee; text-align: left; }
                .total-row td { font-weight: bold; font-size: 14px; border-top: 2px solid #00b074; padding-top: 10px; }
                .footer { text-align: center; margin-top: 40px; font-size: 10px; color: #888; border-top: 1px dashed #ddd; padding-top: 8px; }
            </style>
        </head>
        <body>
            <div class='invoice-box'>
                <table class='table-header'>
                    <tr>
                        <td class='title-header'>OFFICIAL PURCHASE ORDER</td>
                        <td class='meta-text'>
                            <strong>PO Number:</strong> #000{$order->id}<br>
                            <strong>Issue Date:</strong> {$order->po_date}<br>
                            <strong>Status:</strong> Approved / Stored
                        </td>
                    </tr>
                </table>

                <table class='details-table'>
                    <tr>
                        <td>
                            <div class='section-title'>Originating Department</div>
                            <strong>Requesting Entity:</strong> {$order->department}<br>
                            <strong>Officer-in-Charge:</strong> {$order->requesting_person}<br>
                            <strong>Email Address:</strong> {$order->email}
                        </td>
                        <td>
                            <div class='section-title'>Logistics & Terms</div>
                            <strong>Supplier Reference ID:</strong> {$order->supplier_id}<br>
                            <strong>Target Delivery:</strong> " . ($order->delivery_date ?? 'Not Specified') . "<br>
                            <strong>Payment Mode:</strong> {$order->payment_mode}<br>
                            <strong>Shipping Terms:</strong> {$order->delivery_terms}
                        </td>
                    </tr>
                    <tr>
                        <td colspan='2' style='padding-top: 10px;'>
                            <div class='section-title'>Fulfillment Destination & Notes</div>
                            <strong>Address:</strong> {$order->address}<br>
                            <strong>Special Remarks:</strong> " . ($order->notes ?? 'None provided') . "
                        </td>
                    </tr>
                </table>

                <div class='section-title'>Line Item Requisition Details</div>
                <table class='items-table'>
                    <thead>
                        <tr>
                            <th>Item Description</th>
                            <th>Category</th>
                            <th>Unit</th>
                            <th style='text-align: right;'>Unit Price</th>
                            <th style='text-align: center;'>Qty</th>
                            <th style='text-align: right;'>Extended Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>";
                    
                    foreach ($items as $item) {
                        $subtotal = number_format($item->price * $item->quantity, 2);
                        $formattedPrice = number_format($item->price, 2);
                        $html .= "
                        <tr>
                            <td><strong>{$item->item_name}</strong></td>
                            <td>" . ($item->category ?? 'General') . "</td>
                            <td>" . ($item->unit ?? 'pcs') . "</td>
                            <td style='text-align: right;'>{$order->currency} {$formattedPrice}</td>
                            <td style='text-align: center;'>{$item->quantity}</td>
                            <td style='text-align: right; font-weight: bold;'>{$order->currency} {$subtotal}</td>
                        </tr>";
                    }

                    $finalTotal = number_format($totalAmount, 2);
                    $html .= "
                        <tr class='total-row'>
                            <td colspan='4'></td>
                            <td style='text-align: center; font-weight: bold;'>TOTAL:</td>
                            <td style='text-align: right; color: #00b074;'>{$order->currency} {$finalTotal}</td>
                        </tr>
                    </tbody>
                </table>

                <div class='footer'>
                    This document serves as a formal electronic presentation of system-validated log entries.<br>
                    Generated on: " . now()->format('Y-m-d H:i:s') . " | Legaspi Procurement Infrastructure
                </div>
            </div>
        </body>
        </html>";

        // Generate the PDF from our HTML template string natively
        $pdf = Pdf::loadHTML($html);
        
        $fileName = "Purchase_Order_000" . $order->id . ".pdf";
        return $pdf->download($fileName);
    }

    // --- FUNCTION 4: PERMANENTLY REMOVE ORDER & ASSIGNED ITEMS ---
    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            // First clear structural relational dependencies (Order Line Items)
            DB::table('order_items')->where('order_id', $id)->delete();
            
            // Delete the main parent record
            DB::table('orders')->where('id', $id)->delete();
        });

        return redirect()->route('orders.index')->with('success', 'Purchase order and its line items were completely deleted successfully.');
    }
}