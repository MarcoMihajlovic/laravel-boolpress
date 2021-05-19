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

Route::get('/', 'HomeController@index')->name('guest-homepage ');

Auth::routes();

Route::prefix('admin')
->namespace('Admin')
->middleware('auth')
->group(Function () {
    Route::get('/', 'HomeController@index') -> name('admin-homepage');
});

/* Route::get('/admin ', 'HomeController@index')->name('admin-homepage')->middleware('auth'); */