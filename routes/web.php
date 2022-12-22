<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmController;
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

Route::get('/', function () {
   return redirect('/films/');
});

Route::get('/films', [FilmController::class, 'index']);

Route::get('films/{slug}', [FilmController::class, 'filmsSlug'])->name('flims');

Auth::routes();

Route::get('/home', function () {
   return redirect('/films/');
});

Route::middleware(['auth'])->group(function(){
    //add comment
    Route::post('add-comment', [FilmController::class, 'addComment'])->name('add.comment');
});