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

Route::get('/borrow', function () {
    return view('borrow');
})->name('borrow');

Route::get('/item/create', [ItemController::class, 'create'])->name('items.create');
Route::post('/item/store', [ItemController::class, 'store'])->name('items.store');

Route::get('/add-item', function() {
    return view('item-form'); // Blade view with the item form
});

Route::post('/add-item', [ItemController::class, 'store']); // Controller to store the item


Route::get('/user_management', function () {
    return view('user_management');
});
