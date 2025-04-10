<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthManager;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\Admin\InventoryController as AdminInventoryController;
use App\Http\Controllers\Borrower\InventoryController as BorrowerInventoryController;
use App\Http\Controllers\Admin\RecordsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\InventoryRequestController;
use App\Http\Controllers\Borrower\ProfileController;
use App\Http\Controllers\Borrower\BorrowedItemsController;
use App\Http\Controllers\Borrower\BorrowEquipmentController;

// ===================
// ✅ Authentication Routes
// ===================
Route::get('/login', [AuthManager::class, 'login'])->name('login');
Route::post('/login', [AuthManager::class, 'loginPost'])->name('login.post');
Route::get('/registration', [AuthManager::class, 'registration'])->name('registration');
Route::post('/registration', [AuthManager::class, 'registrationPost'])->name('registration.post');
Route::post('/logout', [AuthManager::class, 'logout'])->name('logout');

// ===================
// ✅ Home Route
// ===================
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Admin Inventory Route
Route::get('/admin/inventory', [AdminInventoryController::class, 'index'])->name('admin.inventory.index')->middleware('auth');

// Borrower Inventory Route
Route::get('/borrower/inventory', [BorrowerInventoryController::class, 'index'])->name('borrower.inventory.index')->middleware('auth');

// ===========================
// Inventory Routes (ItemController)
// ===========================

Route::controller(ItemController::class)->group(function () {
    // Display all items in the inventory
    Route::get('/inventory', 'index')->name('inventory'); 

    // Store a new item (this is the route to save both the `items` and `individual_items`)
    Route::post('/items/store', 'store')->name('items.store'); // Explicitly define post for storing items

    // Show edit form for an item
    Route::get('/items/{id}/edit', 'editItem')->name('items.edit'); 

    // Update item details
    Route::put('/items/{id}', 'update')->name('items.update'); 

    // Permanently delete item
    Route::delete('/items/{id}', 'deletePermanently')->name('items.destroy'); 

    // Routes for Archiving (Soft Delete), Restoring, and Permanently Deleting Items
    Route::post('/archive-item/{id}', 'archiveItem')->name('archive.item');    // Archive (soft delete)
    Route::post('/restore-item/{id}', 'restoreItem')->name('restore.item');    // Restore (unarchive)
    Route::delete('/delete-item/{id}', 'deletePermanently')->name('delete.item'); // Permanently delete an archived item

    // Route for fetching item data for editing
    Route::get('/get-item/{id}', 'editItem')->name('get.item.data'); // Fetch item data for editing
    
    // Route for searching an item by its name
    Route::get('/search-item/{name}', 'searchItem')->name('search.item'); // Search item by name
});

// ===========================
// Admin Routes (Protected by Authentication Middleware)
// ===========================
Route::prefix('admin')->middleware(['auth'])->group(function () {
    // Admin Inventory Route
    Route::get('/inventory', [AdminInventoryController::class, 'index'])->name('admin.inventory.index');

    // Records Management
    Route::get('/records', [RecordsController::class, 'index'])->name('records.index');
    Route::post('/records/store', [RecordsController::class, 'store'])->name('records.store'); // ✅ Added Store Route for Records

    // User Management
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::get('/users/{id}/edit', [UsersController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UsersController::class, 'update'])->name('users.update');
    Route::post('/users/store', [UsersController::class, 'store']);
});

// ===========================
// Borrower Routes (Borrower Inventory Controller)
// ===========================
Route::prefix('borrower')->middleware(['auth'])->group(function () {
    // Borrower Inventory Route
    Route::get('/inventory', [BorrowerInventoryController::class, 'index'])->name('borrower.inventory.index');
});

// ===========================
// Profile Routes
// ===========================
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index')->middleware('auth');

// ===========================
// Borrowed Items Routes
// ===========================
Route::prefix('borrower')->middleware(['auth'])->group(function () {
    Route::get('/borrow-equipment', [BorrowedItemsController::class, 'index'])->name('borrower.borrow-equipment.index');
    Route::get('/borrow-equipment/create', [BorrowedItemsController::class, 'create'])->name('borrower.borrow-equipment.create');
    Route::post('/borrow-equipment', [BorrowedItemsController::class, 'store'])->name('borrower.borrow-equipment.store');
    Route::get('/borrow-equipment/{borrowedItem}/edit', [BorrowedItemsController::class, 'edit'])->name('borrower.borrow-equipment.edit');
    Route::put('/borrow-equipment/{borrowedItem}', [BorrowedItemsController::class, 'update'])->name('borrower.borrow-equipment.update');
    Route::delete('/borrow-equipment/{borrowedItem}', [BorrowedItemsController::class, 'destroy'])->name('borrower.borrow-equipment.destroy');
});

// ===========================
// Borrowing Request Routes
// ===========================
Route::get('/borrowing-request', [InventoryRequestController::class, 'index'])->name('admin.borrowing-request.index');

// ===========================
// Returning Items Routes
// ===========================
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/return-items', [ReturnItemsController::class, 'index'])->name('admin.return-items.index');
    Route::post('/return-items/mark/{id}', [ReturnItemsController::class, 'markAsReturned'])->name('admin.return-items.mark');
});
