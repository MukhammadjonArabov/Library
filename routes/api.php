<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\BorrowingController;

//   Book
Route::get('/books', BookController::class); 
Route::get('/books/{book}', [BookController::class, 'show']);
Route::post('/book', [BookController::class, 'store']);
Route::put('/books/{book}', [BookController::class, 'update']);
Route::delete('/books/{book}', [BookController::class, 'destroy']);

// Author
Route::get('/authors', [AuthorController::class, 'index']);