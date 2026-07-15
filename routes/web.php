<?php
use Illuminate\Support\Facades\Route;
use Leeuwenkasteel\Stock\Http\Controllers\AppController;

	Route::prefix('stock/app')
    ->middleware(['web'])
    ->group(function () {
	
		Route::get('index', [AppController::class, 'login'])->name('stock.login');
		
		Route::middleware('app.auth:stock')->group(function () {
			Route::get('home', [AppController::class, 'home'])->name('stock.home');
			Route::get('scan', [AppController::class, 'scan'])->name('stock.scan');
		});
	});
	
    Route::middleware(['web','auth'])->group(function () {
        Route::prefix('admin')->group(function () {
			Route::get('stocks/install', [AppController::class, 'index'])->name('stock.install');
		});
	});