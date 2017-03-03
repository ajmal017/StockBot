<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => '/api'], function() {
	Route::get('/stock/{stockCode}', 'StockApiController@getStockData');
	Route::get('/stock/{stockCode}/summary', 'StockApiController@getSummaryStockData');

	Route::post('/watchedStock', 'StockApiController@addWatchedStock');
	Route::post('/watchedStock/{stockCode}/{isActive}', 'StockApiController@setWatchedStockStatus');
});