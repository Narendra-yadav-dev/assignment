<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Http\Controllers\UserController;
 
Route::post('/login', [UserController::class, 'login']);
Route::get('/index', [UserController::class, 'index']);
Route::get('/logout', [UserController::class, 'logout']);
Route::get('/authors', [AuthorController::class, 'authors']);
Route::post('/authorAddNew', [AuthorController::class, 'authorAddNew']);
Route::get('/authorAdd', [AuthorController::class, 'authorAdd']);
Route::get('/books', [BookController::class, 'books']);
Route::post('/bookAddNew', [BookController::class, 'bookAddNew']);
Route::get('/book_add', [BookController::class, 'bookAdd']);
Route::get('/book_delete/{id}', [BookController::class, 'bookDelete']);
Route::get('/book_view/{id}', [BookController::class, 'bookView']);
Route::get('/author_delete/{id}', [AuthorController::class, 'authorDelete']);
Route::get('/author_view/{id}', [AuthorController::class, 'authorView']);
Route::get('/', function () {
    return view('welcome');
});
