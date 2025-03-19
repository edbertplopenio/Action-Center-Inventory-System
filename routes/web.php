<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthManager;
use App\Http\Controllers\ItemController;

// Home Route
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication Routes
Route::controller(AuthManager::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'loginPost')->name('login.post');
    Route::get('/registration', 'registration')->name('registration');
    Route::post('/registration', 'registrationPost')->name('registration.post');
    Route::get('/logout', 'logout')->name('logout');
});

// Inventory Routes
Route::controller(ItemController::class)->group(function () {
    Route::get('/inventory', 'index')->name('inventory'); // Display inventory items
    Route::post('/items/store', 'store')->name('items.store'); // Store new item
    Route::get('/items/{id}/edit', 'edit')->name('items.edit'); // Edit item
    Route::put('/items/{id}', 'update')->name('items.update'); // Update item
    Route::delete('/items/{id}', 'destroy')->name('items.destroy'); // Delete item
});

