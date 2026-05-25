<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Critical Low Stock Report</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 25px; border-bottom: 2px solid #dc2626; padding-bottom: 10px; }
        .header h1 { margin: 0; color: #dc2626; text-transform: uppercase; font-size: 20px; }
        .header p { margin: 5px 0 0; color: #666; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background-color: #fef2f2; color: #991b1b; font-weight: bold; text-align: left; padding: 8px; border: 1px solid #fca5a5; font-size: 11px; }
        td { padding: 8px; border: 1px solid #fca5a5; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .status-danger { color: #b91c1c; font-weight: bold; background-color: #fee2e2; border-radius: 4px; padding: 2px 5px; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: right; font-size: 9px; color: #999; border-top: 1px solid #eee; padding-top: 5px; }
        .summary { margin-top: 25px; background-color: #fdf2f2; padding: 15px; border-radius: 8px; border: 1px solid #fee2e2; }
        .summary-item { margin-bottom: 5px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Critical Low Stock Warning Report</h1>
        <p>Replenishment Required | Generated on: {{ date('F d, Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Part Number</th>
                <th>Part Name</th>
                <th>Category</th>
                <th>Machine</th>
                <th class="text-right">Price</th>
                <th class="text-center">Current Stock</th>
                <th class="text-center">Reorder Level</th>
                <th class="text-center">Deficit</th>
            </tr>
        </thead>
        <tbody>
            @foreach($spareParts as $part)
            <tr>
                <td><code>{{ $part->part_number }}</code></td>
                <td style="font-weight: bold;">{{ $part->name }}</td>
                <td>{{ $part->category->name ?? 'N/A' }}</td>
                <td>{{ $part->machine->name ?? 'N/A' }}</td>
                <td class="text-right">₹{{ number_format($part->unit_price, 2) }}</td>
                <td class="text-center">
                    <span class="status-danger">{{ $part->stock_quantity }}</span>
                </td>
                <td class="text-center">{{ $part->reorder_point }}</td>
                <td class="text-center" style="color: #b91c1c; font-weight: bold;">
                    {{ max(0, $part->reorder_point - $part->stock_quantity) }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <div class="summary-item"><strong>Critical Items Requiring Restock:</strong> {{ $spareParts->count() }} items</div>
        <div class="summary-item"><strong>Estimated Restoration Cost:</strong> ₹{{ number_format($spareParts->sum(function($p) { return max(0, $p->reorder_point - $p->stock_quantity) * $p->unit_price; }), 2) }}</div>
    </div>

    <div class="footer">
        InvControl System - Optimum Inventory Control of Machine Spares
    </div>
</body>
</html>
