<?php

use App\Http\Controllers\AuthManager;
use Illuminate\Support\Facades\Route;

// Authentication routes
Route::get('/login', [AuthManager::class, 'login'])->name('login');
Route::post('/login', [AuthManager::class, 'loginPost'])->name('login.post');
Route::get('/registration', [AuthManager::class, 'registration'])->name('registration'); // Registration route
Route::post('/registration', [AuthManager::class, 'registrationPost'])->name('registration.post');
Route::get('/logout', [AuthManager::class, 'logout'])->name('logout');

// Inventory Routes
Route::get('/inven', [ItemController::class, 'index'])->name('inventory');

// Item Routes
Route::get('/item/create', [ItemController::class, 'create'])->name('items.create'); // Show the create form
Route::post('/item/store', [ItemController::class, 'store'])->name('items.store'); // Store the new item

// Route to check if the item exists
Route::post('/items/checkExistence', [ItemController::class, 'checkExistence'])->name('items.checkExistence');

// Route to update an existing item
Route::post('/items/update', [ItemController::class, 'update'])->name('items.update');

// Archive and Restore Routes
Route::post('/archive-item/{id}', [ItemController::class, 'archiveItem'])->name('archive-item');
Route::post('/restore-item/{id}', [ItemController::class, 'restoreItem'])->name('restore-item');

// Borrow page
Route::get('/borrow', function () {
    return view('borrow');
})->name('borrow');

// User Management
Route::get('/user_management', function () {
    return view('user_management');
});

// Edit Item Route
Route::post('/edit-item/{id}', [ItemController::class, 'editItem'])->name('edit-item'); // Update item

// Remove the unnecessary `get-item` route as it was undefined:
# Route::get('/get-item/{id}', 'ItemController@getItem');
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
