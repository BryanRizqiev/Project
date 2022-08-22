<?php

use App\Http\Controllers\InsertController;
use Illuminate\Support\Facades\Route;

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

Route::get('/',  [InsertController::class, 'index'])->name('dashboard');

Route::post('/insert', [InsertController::class, 'store']);
// Route::post('/search', [InsertController::class, 'search']);
Route::post('/destroy/{id}', [InsertController::class, 'destroy']);

// Route::get('/welcome', function () {
//     return view('welcome');
// })->name('welcome');

Route::get('/statistik', [InsertController::class, 'statistic'])->name('statistic');

Route::post('/updateAll', [InsertController::class, 'updateAllData']);

Route::get('/blank-page', function () {
    return view('pages.blank');
})->name('blank-page');

// Route::get('/404', function () {
//     return view('pages.404');
// })->name('404-page');