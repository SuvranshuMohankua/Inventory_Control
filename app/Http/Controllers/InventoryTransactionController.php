<?php

namespace App\Http\Controllers;

use App\Models\InventoryTransaction;
use App\Models\SparePart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = InventoryTransaction::with(['sparePart', 'user']);

        if ($request->has('type') && $request->type != '') {
            $query->where('transaction_type', strtoupper($request->type));
        }

        if ($request->has('start_date') && $request->start_date != '') {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date != '') {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $transactions = $query->latest()->paginate(15)->withQueryString();
        
        return view('transactions.index', compact('transactions'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $spareParts = SparePart::all();
        $selectedPartId = $request->query('spare_part_id');
        $type = $request->query('type', 'out'); // Default to stock out (issuing)
        
        return view('transactions.create', compact('spareParts', 'selectedPartId', 'type'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'spare_part_id' => 'required|exists:spare_parts,id',
            'transaction_type' => 'required|in:in,out,IN,OUT',
            'quantity' => 'required|integer|min:1',
            'remarks' => 'nullable|string|max:255'
        ]);

        try {
            DB::beginTransaction();

            // Create the transaction
            $transaction = InventoryTransaction::create([
                'spare_part_id' => $request->spare_part_id,
                'transaction_type' => strtoupper($request->transaction_type),
                'quantity' => $request->quantity,
                'remarks' => $request->remarks,
                'user_id' => auth()->id()

            ]);

            // Update Spare Part stock
            $sparePart = SparePart::findOrFail($request->spare_part_id);
            if (strtolower($request->transaction_type) === 'in') {
                $sparePart->increment('stock_quantity', $request->quantity);
            } else {
                // Check if enough stock
                if ($sparePart->stock_quantity < $request->quantity) {
                    throw new \Exception("Insufficient stock for this transaction.");
                }
                $sparePart->decrement('stock_quantity', $request->quantity);
            }

            DB::commit();

            return redirect()->route('spare-parts.show', $request->spare_part_id)
                ->with('success', 'Transaction recorded and stock updated.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(InventoryTransaction $transaction)
    {
        return view('transactions.show', compact('transaction'));
    }

    /**
     * Export transactions to CSV.
     */
    public function export()
    {
        $fileName = 'inventory_transactions_' . date('Y-m-d') . '.csv';
        $transactions = InventoryTransaction::with('sparePart')->latest()->get();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Date', 'Part Name', 'Part Number', 'Type', 'Quantity', 'Remarks');

        $callback = function() use($transactions, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($transactions as $transaction) {
                fputcsv($file, array(
                    $transaction->created_at,
                    $transaction->sparePart->name,
                    $transaction->sparePart->part_number,
                    strtolower($transaction->transaction_type) == 'in' ? 'Stock In' : 'Stock Out',
                    $transaction->quantity,
                    $transaction->remarks
                ));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}


