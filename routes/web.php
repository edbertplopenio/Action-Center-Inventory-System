<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthManager;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\Admin\RecordsController;
use App\Http\Controllers\Admin\UsersController;

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

// ===================
// ✅ Inventory Routes
// ===================
Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');

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

