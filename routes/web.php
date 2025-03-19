<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthManager;
use App\Http\Controllers\ItemController;

// ===========================
// Home Route
// ===========================
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ===========================
// Authentication Routes
// ===========================
Route::controller(AuthManager::class)->group(function () {
    Route::get('/login', 'login')->name('login'); // Show login form
    Route::post('/login', 'loginPost')->name('login.post'); // Process login
    Route::get('/registration', 'registration')->name('registration'); // Show registration form
    Route::post('/registration', 'registrationPost')->name('registration.post'); // Process registration
    Route::get('/logout', 'logout')->name('logout'); // Logout user
});

// ===========================
// Inventory Routes
// ===========================
Route::controller(ItemController::class)->group(function () {
    Route::get('/inventory', 'index')->name('inventory'); // Display all items
    Route::post('/items/store', 'store')->name('items.store'); // Store a new item
    Route::get('/items/{id}/edit', 'edit')->name('items.edit'); // Show edit form
    Route::put('/items/{id}', 'update')->name('items.update'); // Update item details
    Route::delete('/items/{id}', 'destroy')->name('items.destroy'); // Permanently delete item

    // Routes for Archiving (Soft Delete), Restoring, and Permanently Deleting Items
    Route::post('/archive-item/{id}', 'archiveItem')->name('archive.item');    // Archive (soft delete)
    Route::post('/restore-item/{id}', 'restoreItem')->name('restore.item');    // Restore (unarchive)
    Route::delete('/delete-item/{id}', 'deletePermanently')->name('delete.item'); // Permanently delete an archived item
});
