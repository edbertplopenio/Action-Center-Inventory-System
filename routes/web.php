<?php

use App\Http\Controllers\AuthManager;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\BorrowingSlipController;


// Authentication routes
Route::get('/login', [AuthManager::class, 'login'])->name('login');
Route::post('/login', [AuthManager::class, 'loginPost'])->name('login.post');
Route::get('/registration', [AuthManager::class, 'registration'])->name('registration'); // Registration route
Route::post('/registration', [AuthManager::class, 'registrationPost'])->name('registration.post');
Route::get('/logout', [AuthManager::class, 'logout'])->name('logout');

// Home route (Dashboard or Home page)
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Home route - can be used for authenticated users
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Inventory routes
Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');


// Admin routes with authentication middleware
use App\Http\Controllers\Admin\RecordsController;
use App\Http\Controllers\Admin\UsersController;

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/records', [RecordsController::class, 'index'])->name('records.index');
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
});

// Sample UI route for testing (can be removed or modified as needed)
Route::get('/sample-ui', function () {
    return view('sample-ui');
});


Route::post('/logout', [AuthManager::class, 'logout'])->name('logout');

Route::post('/borrow/submit', function (Illuminate\Http\Request $request) {
    // Handle form submission logic here
    return back()->with('success', 'Borrowing request submitted.');
})->name('borrow.submit');

Route::get('/borrowing-slip', [BorrowingSlipController::class, 'index'])->name('borrowing-slip.index');

Route::post('/borrowing-slip', [BorrowingSlipController::class, 'store'])->name('borrowing-slip.store');

Route::get('/borrowing-slip', [BorrowingSlipController::class, 'index'])->name('borrowing-slip.index');
Route::post('/borrowing-slip', [BorrowingSlipController::class, 'store'])->name('borrowing-slip.store');

Route::delete('/borrowing-slip/{id}', [BorrowingSlipController::class, 'destroy']);

Route::put('/borrowing-slip/{id}', [BorrowingSlipController::class, 'update'])->name('borrowing-slip.update');


