<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\WatchedStock;
use Illuminate\Http\Request;

class StockApiController extends Controller
{
    public function getSummaryStockData($stockCode)
    {
    	$results = Stock::where('stockCode', $stockCode)
		    ->orderBy('date', 'desc')
		    ->take(8)
		    ->get();

    	return $results->toJson();
    }

    public function getStockData($stockCode)
    {
	    $results = Stock::where('stockCode', $stockCode)
		    ->get();

	    return $results->toJson();
    }

    public function addWatchedStock(Request $request)
    {
    	$data = $request->only(['stockCode']);

    	$watchedStock = WatchedStock::create($data);

    	return $watchedStock->toJson();
    }

    public function setWatchedStockStatus($stockCode, $isActive)
    {
    	$watchedStock = WatchedStock::where('stockCode', $stockCode)
		    ->update(['isActive' => $isActive]);

    	return $watchedStock->toJson();
    }
}
