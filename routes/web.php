<?php
use Illuminate\Support\Facades\Route;
use Leeuwenkasteel\Stock\Http\Controllers\AppController;

Route::middleware(['web'])->group(function () {
	
	Route::prefix('stock/app')->group(function () {
		Route::get('index', [AppController::class, 'login'])->name('stock.login');
		
		
		//Route::middleware('cashdesk.auth')->group(function () {
			Route::get('home', [AppController::class, 'scan'])->name('cashdesk.scan');

		//});
	});
    Route::middleware(['cauth'])->group(function () {
        Route::prefix('admin')->group(function () {
			Route::get('stock/install', [AppController::class, 'index'])->name('stock.install');
		});
	});
});