<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\SparePartController;
use App\Http\Controllers\InventoryTransactionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('landing');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    // ----------------------------------------------------
    // Shared & Administrative Catalog Access (Optimized)
    // ----------------------------------------------------
    
    // 1. Categories
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::middleware('manager')->group(function () {
        Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
    });
    Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    Route::middleware('manager')->group(function () {
        Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    });

    // 2. Machines
    Route::get('machines', [MachineController::class, 'index'])->name('machines.index');
    Route::middleware('manager')->group(function () {
        Route::get('machines/create', [MachineController::class, 'create'])->name('machines.create');
        Route::post('machines', [MachineController::class, 'store'])->name('machines.store');
    });
    Route::get('machines/{machine}', [MachineController::class, 'show'])->name('machines.show');
    Route::middleware('manager')->group(function () {
        Route::get('machines/{machine}/edit', [MachineController::class, 'edit'])->name('machines.edit');
        Route::put('machines/{machine}', [MachineController::class, 'update'])->name('machines.update');
        Route::delete('machines/{machine}', [MachineController::class, 'destroy'])->name('machines.destroy');
    });

    // 3. Spare Parts
    Route::get('spare-parts', [SparePartController::class, 'index'])->name('spare-parts.index');
    Route::get('spare-parts/export-pdf', [SparePartController::class, 'exportPdf'])->name('spare-parts.export-pdf');
    Route::get('spare-parts/export-csv', [SparePartController::class, 'exportCsv'])->name('spare-parts.export-csv');
    Route::middleware('manager')->group(function () {
        Route::get('spare-parts/create', [SparePartController::class, 'create'])->name('spare-parts.create');
        Route::post('spare-parts', [SparePartController::class, 'store'])->name('spare-parts.store');
    });
    Route::get('spare-parts/{spare_part}', [SparePartController::class, 'show'])->name('spare-parts.show');
    Route::middleware('manager')->group(function () {
        Route::get('spare-parts/{spare_part}/edit', [SparePartController::class, 'edit'])->name('spare-parts.edit');
        Route::put('spare-parts/{spare_part}', [SparePartController::class, 'update'])->name('spare-parts.update');
        Route::delete('spare-parts/{spare_part}', [SparePartController::class, 'destroy'])->name('spare-parts.destroy');
    });

    // 4. Transactions
    Route::get('transactions/export', [InventoryTransactionController::class, 'export'])->name('transactions.export');
    Route::resource('transactions', InventoryTransactionController::class)->only(['index', 'show', 'create', 'store']);

    // ----------------------------------------------------
    // Shared Reports Access
    // ----------------------------------------------------
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/low-stock', [ReportController::class, 'lowStock'])->name('reports.low-stock');
    Route::get('reports/low-stock/export', [ReportController::class, 'exportLowStock'])->name('reports.low-stock.export');

    // ----------------------------------------------------
    // Administrative Access Only (Admin Only)
    // ----------------------------------------------------
    Route::middleware('admin')->group(function () {
        // Financial reports
        Route::get('reports/valuation', [ReportController::class, 'valuation'])->name('reports.valuation');
        Route::get('reports/valuation/export', [ReportController::class, 'exportValuation'])->name('reports.valuation.export');

        // User Management
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::patch('users/{user}/role', [UserController::class, 'updateRole'])->name('users.update-role');
    });

    // Profile Settings (Shared)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
