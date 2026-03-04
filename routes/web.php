<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Redirect root to specific landing based on Auth status
Route::get('/', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    
    if (Auth::user()->role === 'admin') {
        return redirect('/admin');
    }
    
    return redirect()->route('order.index');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [WebAuthController::class, 'showLogin'])->name('login');
    Route::post('login', [WebAuthController::class, 'login']);
    
    Route::get('register', function () {
        return view('register');
    })->name('register');
    Route::post('register', [WebAuthController::class, 'register']);
});

Route::post('logout', [WebAuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/order', [ProductController::class, 'index'])->name('order.index');

Route::middleware('auth')->group(function () {
    Route::get('/history', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/checkout', [OrderController::class, 'store'])->name('orders.store');
});
