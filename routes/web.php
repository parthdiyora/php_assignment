<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth.middleware'])->group(function () {
    // Author routes
    Route::get('/authors',[AuthorController::class, 'index'] )->name('authors.index');
    Route::get('/authors/data', [AuthorController::class, 'fetchAuthors'])->name('authors.data');
    Route::get('/authors/{id}', [AuthorController::class, 'show'])->name('authors.show');
    Route::delete('/authors/{id}', [AuthorController::class, 'destroy'])->name('authors.destroy');

    // Book routes
    Route::get('/books/create', [AuthorController::class, 'createBook'])->name('books.create');
    Route::post('/books/store', [AuthorController::class, 'storeBook'])->name('books.store');
    Route::delete('/books/{bookId}', [AuthorController::class, 'deleteBook'])->name('books.delete');

    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
});

require __DIR__.'/auth.php';
