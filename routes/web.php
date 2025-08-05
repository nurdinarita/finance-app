<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\TransactionController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::group(['prefix' => 'accounts'], function () {
    Route::get('/', [AccountController::class, 'index'])->name('accounts');
    Route::get('/create', [AccountController::class, 'create'])->name('accounts.create');
    Route::post('/store', [AccountController::class, 'store'])->name('accounts.store');
    Route::get('/{account}/edit', [AccountController::class, 'edit'])->name('accounts.edit');
    Route::put('/{account}', [AccountController::class, 'update'])->name('accounts.update');
    Route::delete('/{account}', [AccountController::class, 'destroy'])->name('accounts.destroy');
});

Route::group(['prefix' => 'transactions'], function () {
    Route::get('/', [TransactionController::class, 'index'])->name('transactions');
    Route::get('/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/store', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/{transaction}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
    Route::put('/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');
    Route::delete('/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
});

