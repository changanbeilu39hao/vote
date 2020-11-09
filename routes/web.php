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
Route::post('/pre', 'CheckController@pre')->name('check.prev');
Route::post('/pre/store', 'CheckController@pre_store')->name('check.store');
Route::post('/pre/confirm', 'CheckController@pre_confirm')->name('check.confirm');

Route::get('/score', 'ScoresController@index')->name('score.index');
Route::post('/score', 'ScoresController@store')->name('score.store');
Route::post('/score/confirm', 'ScoresController@confirm')->name('score.confirm');

Route::get('score/detail/{id}', 'ScoresController@detail')->name('score.detail');
Route::get('score/show', 'ScoresController@show')->name('score.show');

Auth::routes();
Route::get('/', function(){
    return redirect(route('check.pre'));
});

// Route::post('check/store', 'CheckController@store')->name('check.store');
// Route::post('check/confirm', 'CheckController@confirm')->name('check.confirm');


