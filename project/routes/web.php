<?php

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

Route::get('/', function () {
    return view('pages.dashboard');
})->name('dashboard');

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');


Route::get('/profile', function () {
    return view('pages.profile');
})->name('profile');

Route::get('/basic-table', function () {
    return view('pages.basic-table');
})->name('basic-table');

Route::get('/icons', function () {
    return view('pages.fontawesome');
})->name('icons');

Route::get('/google-map', function () {
    return view('pages.map-google');
})->name('google-map');

Route::get('/blank-page', function () {
    return view('pages.blank');
})->name('blank-page');

Route::get('/404', function () {
    return view('pages.404');
})->name('404-page');