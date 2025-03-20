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
    // Display all items in the inventory
    Route::get('/inventory', 'index')->name('inventory'); 

    // Store a new item
    Route::post('/items/store', 'store')->name('items.store'); 

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
    Route::put('/items/{id}', 'ItemController@update')->name('items.update');

});
