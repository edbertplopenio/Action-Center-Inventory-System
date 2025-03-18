<?php

use App\Http\Controllers\AuthManager;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\BorrowingSlipController;
use App\Http\Controllers\Admin\RecordsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\EquipmentController;

// Authentication routes
Route::get('/login', [AuthManager::class, 'login'])->name('login');
Route::post('/login', [AuthManager::class, 'loginPost'])->name('login.post');
Route::get('/registration', [AuthManager::class, 'registration'])->name('registration');
Route::post('/registration', [AuthManager::class, 'registrationPost'])->name('registration.post');
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login'); // Redirect to login page
})->name('logout');

// Home route
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Dashboard/Home route for authenticated users
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Inventory routes
Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');

// Admin routes with authentication middleware
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/records', [RecordsController::class, 'index'])->name('records.index');
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
});

// Sample UI route for testing
Route::get('/sample-ui', function () {
    return view('sample-ui');
});

// Borrowing Slip Routes (CRUD)
Route::prefix('borrowing-slip')->group(function () {
    Route::get('/', [BorrowingSlipController::class, 'index'])->name('borrowing-slip.index');
    Route::post('/', [BorrowingSlipController::class, 'store'])->name('borrowing-slip.store');
    Route::get('/{id}/edit', [BorrowingSlipController::class, 'edit'])->name('borrowing-slip.edit');
    Route::put('/{id}', [BorrowingSlipController::class, 'update'])->name('borrowing-slip.update');
    Route::delete('/{id}', [BorrowingSlipController::class, 'destroy'])->name('borrowing-slip.destroy');
    Route::get('/{id}', [BorrowingSlipController::class, 'show'])->name('borrowing-slip.show');
});

// Borrowing request submission route
Route::post('/borrow/submit', function (Illuminate\Http\Request $request) {
    return back()->with('success', 'Borrowing request submitted.');
})->name('borrow.submit');

// Borrowing Slip Approval Route
Route::post('/borrowing-slip/{id}/approve', [BorrowingSlipController::class, 'approve'])->name('borrowing-slip.approve');

// Dashboard route (requires authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
});
Route::get('/inventory', [EquipmentController::class, 'index'])->name('inventory.index');
