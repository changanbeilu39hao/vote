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
Route::get('score/last_score', 'ScoresController@last_score')->name('score.last');
Route::post('score/last_score_choose', 'ScoresController@last_score_choose');
Route::post('score/last_score_confirm', 'ScoresController@last_score_confirm');

Route::middleware('page-cache')->get('ranks/{id}', 'RanksController@index')->name('Ranks.index');
Route::middleware('page-cache')->get('city', 'RanksController@city');

Route::get('last_score', 'LastScoresController@index');
Route::post('/last_score', 'LastScoresController@store');

Auth::routes();
Route::get('/', function(){
    return redirect(route('check.pre'));
});

Route::get('/ranks', function(){
    return redirect('/ranks/1');
});


// Route::post('check/store', 'CheckController@store')->name('check.store');
// Route::post('check/confirm', 'CheckController@confirm')->name('check.confirm');


