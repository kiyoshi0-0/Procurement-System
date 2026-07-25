<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Goods Receipts PDF</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #cbd5e1; padding: 8px; text-align: left; }
        th { background-color: #f1f5f9; }
    </style>
</head>
<body>
    <h2>Goods Receipt Shipment Logs</h2>
    <table>
        <thead>
            <tr>
                <th>Receipt #</th>
                <th>PO Number</th>
                <th>Supplier</th>
                <th>Item</th>
                <th>Ordered</th>
                <th>Received</th>
                <th>Warehouse</th>
            </tr>
        </thead>
        <tbody>
            @foreach($receipts as $receipt)
            <tr>
                <td>{{ $receipt->gr_number }}</td>
                <td>{{ $receipt->po_number }}</td>
                <td>{{ $receipt->supplier }}</td>
                <td>{{ $receipt->item_name }}</td>
                <td>{{ $receipt->po_quantity }}</td>
                <td>{{ $receipt->gr_quantity }}</td>
                <td>{{ $receipt->warehouse }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html> 