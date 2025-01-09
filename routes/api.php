<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\productsController;
use App\Http\Controllers\Api\currencyController;
use App\Http\Controllers\Api\pricesController;

/** Products Routes */
Route::get('/products', [productsController::class, 'index']);
Route::get('/products/{id}', [productsController::class, 'show']);
Route::post('/products', [productsController::class, 'store']);
Route::put('/products/{id}', [productsController::class, 'update']);
Route::delete('/products/{id}', [productsController::class, 'destroy']);


/** Prices Routes */
Route::get('/products/{id}/prices', [pricesController::class, 'show']);
Route::post('/products/{id}/prices', [pricesController::class, 'store']);


/** Currency Routes */
Route::get('/currency', [currencyController::class, 'index']);
Route::get('/currency/{id}', [currencyController::class, 'show']);
Route::post('/currency', [currencyController::class, 'store']);
Route::put('/currency/{id}', [currencyController::class, 'update']);
Route::delete('/currency/{id}', [currencyController::class, 'destroy']);
