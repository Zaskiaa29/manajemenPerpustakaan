<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Models\Book;


// Route::get('/', function () {
//     return redirect()->route('books.index');
// });
Route::get('/', function () {
    $books = Book::latest()->get(); 
    return view('home', compact('books'));
})->name('home');


Route::resource('books', BookController::class);
Route::resource('categories', CategoryController::class);