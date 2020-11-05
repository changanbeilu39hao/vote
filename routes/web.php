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


Auth::routes();

Route::get('/pre', 'CheckController@pre')->name('check.pre');
Route::post('/pre/store', 'CheckController@pre_store')->name('check.store');

Auth::routes();
Route::get('/', 'CheckController@index');

// Route::post('check/store', 'CheckController@store')->name('check.store');
// Route::post('check/confirm', 'CheckController@confirm')->name('check.confirm');


