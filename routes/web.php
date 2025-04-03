<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthManager;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Borrower\InventoryController as BorrowerInventoryController;  // Import Borrower Inventory Controller
use App\Http\Controllers\Admin\InventoryController as AdminInventoryController;  // Import Admin Inventory Controller
use App\Http\Controllers\Borrower\InventoryController;
use App\Http\Controllers\Borrower\BorrowedEquipmentController;
use App\Http\Controllers\Borrower\BorrowEquipmentController; 
use App\Http\Controllers\Admin\RecordsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Borrower\ProfileController;  // Import the ProfileController

use App\Http\Controllers\Admin\InventoryRequestController;



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





// ===================
// ✅ Admin Routes (Protected by Authentication Middleware)
// ===================
Route::prefix('admin')->middleware(['auth'])->group(function () {
    // Records Management
    Route::get('/records', [RecordsController::class, 'index'])->name('records.index');
    Route::post('/records/store', [RecordsController::class, 'store'])->name('records.store'); // ✅ Added Store Route for Records

    // User Management
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
});

// ===================
// ✅ Sample UI Route (For Testing UI Components, Optional)
// ===================
Route::get('/sample-ui', function () {
    return view('sample-ui');
});


Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/records', [RecordsController::class, 'index'])->name('records.index');
    Route::get('/records/archive', [RecordsController::class, 'archiveIndex'])->name('records.archive');
    Route::post('/records/archive/{id}', [RecordsController::class, 'archive'])->name('records.archive.store');
    Route::post('/records/restore/{id}', [RecordsController::class, 'restore'])->name('records.restore');
});




Route::post('/submit-record', [RecordsController::class, 'store'])->name('records.store');
Route::post('/records/archive/{id}', [RecordsController::class, 'archive'])->name('records.archive.store');


Route::get('/admin/records/archive', [RecordsController::class, 'archiveIndex'])->name('records.archive');


Route::post('/admin/records/unarchive/{id}', [RecordsController::class, 'unarchive'])->name('records.unarchive');
Route::put('/admin/records/{id}', [RecordsController::class, 'update'])->name('records.update');

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
});


Route::post('/admin/users/store', [UsersController::class, 'store']);


Route::get('/admin/users/{id}/edit', [UsersController::class, 'edit'])->name('users.edit');

Route::put('/admin/users/{id}', [UsersController::class, 'update'])->name('users.update');





Route::post('/admin/users/deactivate/{id}', [UsersController::class, 'deactivate'])->name('users.deactivate');

Route::get('/admin/users/deactivated', [UsersController::class, 'deactivatedIndex'])->name('users.deactivated');


Route::post('/admin/users/activate/{id}', [UsersController::class, 'activate'])->name('users.activate');



// Profile Route for Borrowers
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index')->middleware('auth');



Route::get('/borrower/inventory', [InventoryController::class, 'index'])->name('borrower.inventory.index');

// Borrowing Request
Route::get('/borrowing-request', [InventoryRequestController::class, 'index'])->name('admin.borrowing-request.index');

use App\Http\Controllers\Borrower\BorrowedItemsController;

// Borrowed Equipment Routes (Borrowers)
Route::prefix('borrower')->middleware(['auth'])->group(function () {
    Route::get('/borrow-equipment', [BorrowedItemsController::class, 'index'])->name('borrower.borrow-equipment.index');
    Route::get('/borrow-equipment/create', [BorrowedItemsController::class, 'create'])->name('borrower.borrow-equipment.create');
    Route::post('/borrow-equipment', [BorrowedItemsController::class, 'store'])->name('borrower.borrow-equipment.store');
    Route::get('/borrow-equipment/{borrowedItem}/edit', [BorrowedItemsController::class, 'edit'])->name('borrower.borrow-equipment.edit');
    Route::put('/borrow-equipment/{borrowedItem}', [BorrowedItemsController::class, 'update'])->name('borrower.borrow-equipment.update');
    Route::delete('/borrow-equipment/{borrowedItem}', [BorrowedItemsController::class, 'destroy'])->name('borrower.borrow-equipment.destroy');
});





// Borrowed Items Routes
Route::middleware('auth')->group(function() {
    // Store a new borrow request
    Route::post('/borrow-item', [BorrowEquipmentController::class, 'store'])->name('borrow.item');

    // Get borrowed items for the logged-in user
    Route::get('/borrowed-items', [BorrowEquipmentController::class, 'index'])->name('borrowed.items');
});



// routes/web.php
Route::post('/admin/inventory-requests/update-status/{id}', [InventoryRequestController::class, 'updateStatus'])->name('admin.updateStatus');




// routes/web.php

use App\Http\Controllers\Admin\ReturnItemsController;

// Admin Returning Items Routes
Route::prefix('admin')->middleware(['auth'])->group(function () {
    // Show list of borrowed items to be returned
    Route::get('/return-items', [ReturnItemsController::class, 'index'])->name('admin.return-items.index');

    // Mark an item as returned
    Route::post('/return-items/mark/{id}', [ReturnItemsController::class, 'markAsReturned'])->name('admin.return-items.mark');
});


Route::get('/admin/borrowing-request', [InventoryRequestController::class, 'index'])->name('admin.borrowing-request.index');


Route::get('/admin/get-item-qr-codes/{itemId}', [InventoryRequestController::class, 'getItemQRCodes']);


Route::post('/admin/inventory-requests/update-item-status', [InventoryRequestController::class, 'updateItemStatus']);

Route::get('/admin/borrowed-items/list/{id}', [ReturnItemsController::class, 'getBorrowedItemsForReturn']);
Route::post('/admin/inventory-requests/update-status/{id}', [InventoryRequestController::class, 'updateStatus']);
