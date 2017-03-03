<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\WatchedStock;
use Illuminate\Http\Request;

class StockController extends Controller
{
	public function index()
	{
		$watchedStockCollections = WatchedStock::where('isActive', true)->get();
		$stockCollections = Stock::whereIn('stockCode', $watchedStockCollections->pluck('stockCode')->all())
			->orderBy('date', 'desc')
			->get();

		$watchedStocks = $watchedStockCollections->toArray();
		$stocks = $stockCollections->groupBy('stockCode')->toArray();

		echo '<pre>';
		print_r($stocks);

		return;
	}

    public function toggleStock(Request $request)
    {
    	$data = $request->only([
    		'stockCode'
	    ]);

    	$stock = WatchedStock::where('stockCode', $data['stockCode'])->count();

    	if ($stock == 0) {
    		WatchedStock::create($data);
	    } else {
    		$watched = WatchedStock::where('stockCode', $data['stockCode'])->first();

    		$watched->isActive = !$watched->isActive;
    		$watched->save();
	    }

	    return url('/');
    }
}
