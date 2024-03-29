<?php

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
    return view('welcome');
});

Route::get('/test', 'test@index');

Route::prefix('api')->group(function () {
    Route::get('player/{id}', 'Api\PlayerController@index');
    Route::get('player/{id}/battlelog', 'Api\PlayerController@battleLog');
});