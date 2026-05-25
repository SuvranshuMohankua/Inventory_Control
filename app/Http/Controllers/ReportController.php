<?php

namespace App\Http\Controllers;

use App\Models\SparePart;
use App\Models\Category;
use App\Models\Machine;
use App\Models\InventoryTransaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Display reports dashboard.
     */
    public function index()
    {
        // 1. General Stats
        $totalParts = SparePart::count();
        $totalStock = SparePart::sum('stock_quantity');
        
        // Sum of stock_quantity * unit_price (raw SQL or collection sum)
        $totalValue = SparePart::all()->sum(function($part) {
            return $part->stock_quantity * $part->unit_price;
        });

        $lowStockCount = SparePart::whereColumn('stock_quantity', '<=', 'reorder_point')->count();

        // 2. Machine-wise Valuation
        $machines = Machine::with('spareParts')->get()->map(function($machine) {
            $machine->total_parts = $machine->spareParts->count();
            $machine->total_value = $machine->spareParts->sum(function($part) {
                return $part->stock_quantity * $part->unit_price;
            });
            return $machine;
        })->sortByDesc('total_value');

        // 3. Category-wise Valuation
        $categories = Category::with('spareParts')->get()->map(function($category) {
            $category->total_parts = $category->spareParts->count();
            $category->total_value = $category->spareParts->sum(function($part) {
                return $part->stock_quantity * $part->unit_price;
            });
            return $category;
        })->sortByDesc('total_value');

        // 4. Low stock parts
        $lowStockParts = SparePart::with(['category', 'machine'])
            ->whereColumn('stock_quantity', '<=', 'reorder_point')
            ->limit(5)
            ->get();

        return view('reports.index', compact(
            'totalParts', 
            'totalStock', 
            'totalValue', 
            'lowStockCount', 
            'machines', 
            'categories',
            'lowStockParts'
        ));
    }

    /**
     * Low stock report.
     */
    public function lowStock(Request $request)
    {
        $query = SparePart::with(['category', 'machine'])
            ->whereColumn('stock_quantity', '<=', 'reorder_point');

        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('machine_id') && $request->machine_id != '') {
            $query->where('machine_id', $request->machine_id);
        }

        $spareParts = $query->latest()->paginate(15)->withQueryString();

        return view('reports.low_stock', compact('spareParts'));
    }

    /**
     * Export Low stock report as PDF.
     */
    public function exportLowStock(Request $request)
    {
        $query = SparePart::with(['category', 'machine'])
            ->whereColumn('stock_quantity', '<=', 'reorder_point');

        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('machine_id') && $request->machine_id != '') {
            $query->where('machine_id', $request->machine_id);
        }

        $spareParts = $query->latest()->get();

        $pdf = Pdf::loadView('reports.low_stock_pdf', compact('spareParts'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('low_stock_report_' . date('Y-m-d') . '.pdf');
    }

    /**
     * Stock Valuation report.
     */
    public function valuation()
    {
        $spareParts = SparePart::with(['category', 'machine'])->get()->map(function($part) {
            $part->total_value = $part->stock_quantity * $part->unit_price;
            return $part;
        })->sortByDesc('total_value');

        return view('reports.valuation', compact('spareParts'));
    }

    /**
     * Export Valuation report as PDF.
     */
    public function exportValuation()
    {
        $spareParts = SparePart::with(['category', 'machine'])->get()->map(function($part) {
            $part->total_value = $part->stock_quantity * $part->unit_price;
            return $part;
        })->sortByDesc('total_value');

        $pdf = Pdf::loadView('reports.valuation_pdf', compact('spareParts'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('stock_valuation_report_' . date('Y-m-d') . '.pdf');
    }
}
