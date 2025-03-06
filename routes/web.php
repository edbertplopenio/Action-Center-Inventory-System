<?php

use App\Http\Controllers\AuthManager;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', [AuthManager::class, 'login'])->name('login');
Route::post('/login', [AuthManager::class, 'loginPost'])->name('login.post');
Route::get('/registration', [AuthManager::class, 'registration'])->name('registration');
Route::post('/registration', [AuthManager::class, 'registrationPost'])->name('registration.post');
Route::get('/logout', [AuthManager::class, 'logout'])->name('logout');

// New route for inven.blade.php
Route::get('/inven', [ItemController::class, 'index'])->name('inventory');

// Item Routes
Route::get('/item/create', [ItemController::class, 'create'])->name('items.create'); // Show the create form
Route::post('/item/store', [ItemController::class, 'store'])->name('items.store'); // Store the new item

// Route to view items in the inventory
Route::get('/inven', [ItemController::class, 'index'])->name('inventory');

// Archive and Restore Routes
Route::post('/archive-item/{id}', [ItemController::class, 'archiveItem'])->name('archive-item');
Route::post('/restore-item/{id}', [ItemController::class, 'restoreItem'])->name('restore-item');

// Borrow page
Route::get('/borrow', function () {
    return view('borrow');
})->name('borrow');

Route::get('/user_management', function () {
    return view('user_management');
});
