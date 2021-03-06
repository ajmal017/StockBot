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

Route::get('/', ['as' => 'home', 'uses' => 'StockController@index']);
Route::get('/stock/{stockCode}', ['as' => 'stock', 'uses' => 'StockController@show']);
Route::post('/stock', ['as' => 'post-stock', 'uses' => 'StockController@store']);

Route::get('/import', 'DataImportController@importAllStockData');