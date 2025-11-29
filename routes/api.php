<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookController;

Route::get('/books', BookController::class); 
Route::get('/books/{book}', [BookController::class, 'show']);
Route::post('/books', [BookController::class, 'store']);