<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckRole;
use App\Exports\InventoryExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\InventoryImport;
use Illuminate\Http\Request;

// Redirect to inventory if open root
Route::get('/', function () {
    return redirect()->route('inventory.index');
})->middleware('auth');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register']);

// Logout Route
Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');

// Inventory Routes
Route::middleware(['auth', 'role:owner,operator,admin'])->group(function () {
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');

    // Create Routes
    Route::get('/inventory/create', [InventoryController::class, 'create'])->name('inventory.create');
    Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');

    // Edit & Delete Routes
    Route::get('/inventory/{id}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
    Route::put('/inventory/{id}', [InventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/inventory/{id}', [InventoryController::class, 'destroy'])->name('inventory.destroy');
});

// Export Route Handler
Route::get('/inventory/export', function () {
    return Excel::download(new InventoryExport, 'inventory.xlsx');
})->name('inventory.export')->middleware(['auth', 'role:owner']);

// Import Route Handler
Route::post('/inventory/import', function (Request $request) {
    $request->validate([
        'file' => 'required|mimes:xlsx,xls,csv'
    ]);

    Excel::import(new InventoryImport, $request->file('file'));

    return redirect()->back()->with('success', 'Import Successful!');
})->name('inventory.import')->middleware(['auth', 'role:owner']);