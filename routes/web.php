<?php

use App\Http\Controllers\AuthManager;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\Admin\RecordsController;
use App\Http\Controllers\Admin\UsersController;


// Route for the users list
Route::get('/users', [UsersController::class, 'index'])->name('users.index');

// Route for displaying a specific user's profile
Route::get('/users/{id}', [UsersController::class, 'show'])->name('users.show');

// Route for updating the user's profile
Route::put('/users/{id}', [UsersController::class, 'update'])->name('users.update');


// Authentication routes
Route::get('/login', [AuthManager::class, 'login'])->name('login');
Route::post('/login', [AuthManager::class, 'loginPost'])->name('login.post');
Route::get('/registration', [AuthManager::class, 'registration'])->name('registration');
Route::post('/registration', [AuthManager::class, 'registrationPost'])->name('registration.post');
Route::get('/logout', [AuthManager::class, 'logout'])->name('logout');
Route::post('/logout', [AuthManager::class, 'logout'])->name('logout');

// Home route (Dashboard)
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/home', [HomeController::class, 'index'])->name('home');

// About page
Route::get('/about-us', function () {
    return view('about');
});

// Inventory routes
Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');

// Admin Panel (Requires Authentication)
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/records', [RecordsController::class, 'index'])->name('records.index');
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
});

// Sample UI Route (For Testing)
Route::get('/sample-ui', function () {
    return view('sample-ui');
});




// User Management Routes
Route::prefix('admin')->middleware(['auth'])->group(function () {
    // Route to list all users
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');

    // Route to view a single user's profile
    Route::get('/users/{id}/profile', [UsersController::class, 'show'])->name('users.show');

    // Route to update user's profile
    Route::put('/users/{id}/profile', [UsersController::class, 'update'])->name('users.update');
});


// Borrowing Slips Management Routes
Route::prefix('borrowing-slip')->group(function () {
    Route::get('/', [BorrowingSlipController::class, 'index'])->name('borrowing-slip.index');
    Route::post('/', [BorrowingSlipController::class, 'store'])->name('borrowing-slip.store');
    Route::get('/{id}/edit', [BorrowingSlipController::class, 'edit'])->name('borrowing-slip.edit');
    Route::put('/{id}', [BorrowingSlipController::class, 'update'])->name('borrowing-slip.update');
    Route::delete('/{id}', [BorrowingSlipController::class, 'destroy'])->name('borrowing-slip.destroy');
});

// Borrow Request Submission (Form Handling)
Route::post('/borrow/submit', function (Illuminate\Http\Request $request) {
    return back()->with('success', 'Borrowing request submitted.');
})->name('borrow.submit');
