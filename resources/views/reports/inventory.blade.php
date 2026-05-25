<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Inventory Report</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #2563eb; padding-bottom: 10px; }
        .header h1 { margin: 0; color: #2563eb; text-transform: uppercase; }
        .header p { margin: 5px 0 0; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background-color: #f3f4f6; color: #111; font-weight: bold; text-align: left; padding: 10px; border: 1px solid #e5e7eb; }
        td { padding: 10px; border: 1px solid #e5e7eb; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .status-low { color: #dc2626; font-weight: bold; }
        .status-good { color: #16a34a; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: right; font-size: 10px; color: #999; border-top: 1px solid #eee; padding-top: 5px; }
        .summary { margin-top: 30px; background-color: #f9fafb; padding: 15px; border-radius: 8px; }
        .summary-item { margin-bottom: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>InvControl Inventory Report</h1>
        <p>Generated on: {{ date('F d, Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Part Number</th>
                <th>Part Name</th>
                <th>Category</th>
                <th>Machine</th>
                <th class="text-right">Price</th>
                <th class="text-center">Stock</th>
                <th class="text-center">Min/Reorder</th>
            </tr>
        </thead>
        <tbody>
            @foreach($spareParts as $part)
            <tr>
                <td><code>{{ $part->part_number }}</code></td>
                <td>{{ $part->name }}</td>
                <td>{{ $part->category->name ?? 'N/A' }}</td>
                <td>{{ $part->machine->name ?? 'N/A' }}</td>
                <td class="text-right">₹{{ number_format($part->unit_price, 2) }}</td>
                <td class="text-center {{ $part->stock_quantity <= $part->reorder_point ? 'status-low' : 'status-good' }}">
                    {{ $part->stock_quantity }}
                </td>
                <td class="text-center text-gray-500">
                    {{ $part->min_stock_level }} / {{ $part->reorder_point }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <div class="summary-item"><strong>Total Unique Parts:</strong> {{ $spareParts->count() }}</div>
        <div class="summary-item"><strong>Total Stock Quantity:</strong> {{ $spareParts->sum('stock_quantity') }}</div>
        <div class="summary-item"><strong>Total Inventory Value:</strong> ₹{{ number_format($spareParts->sum(function($p) { return $p->stock_quantity * $p->unit_price; }), 2) }}</div>
    </div>

    <div class="footer">
        InvControl System - Optimum Inventory Control of Machine Spares
    </div>
</body>
</html>
