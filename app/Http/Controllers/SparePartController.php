<?php

namespace App\Http\Controllers;

use App\Models\SparePart;
use App\Models\Category;
use App\Models\Machine;
use Illuminate\Http\Request;

class SparePartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SparePart::with(['category', 'machine']);

        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('part_number', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('machine_id') && $request->machine_id != '') {
            $query->where('machine_id', $request->machine_id);
        }

        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        $spareParts = $query->latest()->paginate(10)->withQueryString();
        
        return view('spare_parts.index', compact('spareParts'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $machines = Machine::all();
        return view('spare_parts.create', compact('categories', 'machines'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'part_number' => 'required|string|max:100|unique:spare_parts',
            'category_id' => 'required|exists:categories,id',
            'machine_id' => 'required|exists:machines,id',
            'stock_quantity' => 'required|integer|min:0',
            'min_stock_level' => 'required|integer|min:0',
            'max_stock_level' => 'required|integer|min:0',
            'reorder_point' => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0'
        ]);

        SparePart::create($request->all());

        return redirect()->route('spare-parts.index')
            ->with('success', 'Spare part created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SparePart $sparePart)
    {
        $sparePart->load(['category', 'machine', 'transactions.user']);
        return view('spare_parts.show', compact('sparePart'));
    }

    /**
     * Export inventory to PDF.
     */
    public function exportPdf(Request $request)
    {
        $query = SparePart::with(['category', 'machine']);

        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('part_number', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('machine_id') && $request->machine_id != '') {
            $query->where('machine_id', $request->machine_id);
        }

        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        $spareParts = $query->latest()->get();
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.inventory', compact('spareParts'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('inventory_report_' . date('Y-m-d') . '.pdf');
    }

    /**
     * Export inventory to CSV.
     */
    public function exportCsv(Request $request)
    {
        $query = SparePart::with(['category', 'machine']);

        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('part_number', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('machine_id') && $request->machine_id != '') {
            $query->where('machine_id', $request->machine_id);
        }

        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        $spareParts = $query->latest()->get();

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=inventory_export_' . date('Y-m-d') . '.csv',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $columns = ['Part Number', 'Name', 'Category', 'Machine', 'Unit Price', 'Stock Quantity', 'Min Stock Level', 'Reorder Point', 'Valuation'];

        $callback = function() use($spareParts, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($spareParts as $part) {
                $row['Part Number']  = $part->part_number;
                $row['Name']    = $part->name;
                $row['Category']  = $part->category->name ?? 'N/A';
                $row['Machine']  = $part->machine->name ?? 'N/A';
                $row['Unit Price']  = $part->unit_price;
                $row['Stock Quantity']  = $part->stock_quantity;
                $row['Min Stock Level']  = $part->min_stock_level;
                $row['Reorder Point']  = $part->reorder_point;
                $row['Valuation']  = $part->stock_quantity * $part->unit_price;

                fputcsv($file, array_values($row));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SparePart $sparePart)
    {
        $categories = Category::all();
        $machines = Machine::all();
        return view('spare_parts.edit', compact('sparePart', 'categories', 'machines'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SparePart $sparePart)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'part_number' => 'required|string|max:100|unique:spare_parts,part_number,' . $sparePart->id,
            'category_id' => 'required|exists:categories,id',
            'machine_id' => 'required|exists:machines,id',
            'stock_quantity' => 'required|integer|min:0',
            'min_stock_level' => 'required|integer|min:0',
            'max_stock_level' => 'required|integer|min:0',
            'reorder_point' => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0'
        ]);

        $sparePart->update($request->all());

        return redirect()->route('spare-parts.index')
            ->with('success', 'Spare part updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SparePart $sparePart)
    {
        $sparePart->delete();

        return redirect()->route('spare-parts.index')
            ->with('success', 'Spare part deleted successfully.');
    }
}

