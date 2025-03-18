<?php

use App\Http\Controllers\AuthManager;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication Routes
Route::get('/login', [AuthManager::class, 'login'])->name('login');
Route::post('/login', [AuthManager::class, 'loginPost'])->name('login.post');
Route::get('/registration', [AuthManager::class, 'registration'])->name('registration');
Route::post('/registration', [AuthManager::class, 'registrationPost'])->name('registration.post');
Route::get('/logout', [AuthManager::class, 'logout'])->name('logout');

// Inventory Routes
Route::get('/inventory', [ItemController::class, 'index'])->name('inventory');

// Item Management Routes
Route::get('/item/create', [ItemController::class, 'create'])->name('items.create'); // Show create form
Route::post('/item/store', [ItemController::class, 'store'])->name('items.store'); // Store new item

// Check if item exists
Route::post('/items/checkExistence', [ItemController::class, 'checkExistence'])->name('items.checkExistence');

// Archive & Restore Routes (Soft Delete)
Route::post('/archive-item/{id}', [ItemController::class, 'archive'])->whereNumber('id')->name('items.archive'); // Archive an item
Route::post('/items/restore/{id}', [ItemController::class, 'restore'])->whereNumber('id')->name('items.restore'); // Restore an archived item

// View archived items
Route::get('/items/archived', [ItemController::class, 'archivedItems'])->name('items.archived');

// Borrow Page
Route::get('/borrow', function () {
    return view('borrow');
})->name('borrow');

// User Management Page
Route::get('/user_management', function () {
    return view('user_management');
})->name('user.management');

Route::get('/items/{id}/edit', [ItemController::class, 'edit']);
Route::post('/items/update', [ItemController::class, 'update']);
Route::put('/items/{id}', [ItemController::class, 'update'])->name('items.update');
