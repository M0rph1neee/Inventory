<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckRole;

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