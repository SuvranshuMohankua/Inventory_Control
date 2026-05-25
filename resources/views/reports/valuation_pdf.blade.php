<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Financial Stock Valuation Report</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 25px; border-bottom: 2px solid #16a34a; padding-bottom: 10px; }
        .header h1 { margin: 0; color: #16a34a; text-transform: uppercase; font-size: 20px; }
        .header p { margin: 5px 0 0; color: #666; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background-color: #f0fdf4; color: #166534; font-weight: bold; text-align: left; padding: 8px; border: 1px solid #bbf7d0; font-size: 11px; }
        td { padding: 8px; border: 1px solid #bbf7d0; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: right; font-size: 9px; color: #999; border-top: 1px solid #eee; padding-top: 5px; }
        .summary { margin-top: 25px; background-color: #f0fdf4; padding: 15px; border-radius: 8px; border: 1px solid #bbf7d0; }
        .summary-item { margin-bottom: 5px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Stock Valuation & Financial Audit Report</h1>
        <p>Asset Summary | Generated on: {{ date('F d, Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Part Number</th>
                <th>Part Name</th>
                <th>Category</th>
                <th>Machine</th>
                <th class="text-right">Unit Price</th>
                <th class="text-center">Stock Qty</th>
                <th class="text-right">Asset Value</th>
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
                <td class="text-center">{{ $part->stock_quantity }}</td>
                <td class="text-right" style="color: #166534; font-weight: bold;">
                    ₹{{ number_format($part->total_value, 2) }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <div class="summary-item"><strong>Total Assets Listed:</strong> {{ $spareParts->count() }} spare parts</div>
        <div class="summary-item"><strong>Total Accumulative Quantity:</strong> {{ $spareParts->sum('stock_quantity') }} units</div>
        <div class="summary-item"><strong>Total Financial Valuation:</strong> ₹{{ number_format($spareParts->sum('total_value'), 2) }}</div>
    </div>

    <div class="footer">
        InvControl System - Optimum Inventory Control of Machine Spares
    </div>
</body>
</html>
