<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', 'HomeController@index')->name('guest-homepage');

Route::prefix('posts')
    ->group(function(){
        Route::get('/', 'PostController@index')->name('posts');
        Route::get('/{slug}', 'PostController@show')->name('post');
    });

    Route::prefix('categories')
    ->group(function(){
        Route::get('/', 'CategoryController@index')->name('categories');
        Route::get('/{slug}', 'CategoryController@show')->name('category');
    });


Auth::routes();

Route::prefix('admin')
    ->namespace('Admin')
    ->middleware('auth')
    ->group(Function () {
        Route::get('/', 'HomeController@index') -> name('admin-homepage');
        Route::resource('/posts', 'PostController');
    });

/* Route::get('/admin ', 'HomeController@index')->name('admin-homepage')->middleware('auth'); */