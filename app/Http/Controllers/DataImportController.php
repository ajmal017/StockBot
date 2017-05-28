<?php

namespace App\Http\Controllers;

use App\Helpers\ImportHelpers;
use App\Models\WatchedStock;
use Carbon\Carbon;

class DataImportController extends Controller
{

	/*
	 * stock data will be in this format
	 * date - open - high - low - close - volume
	 */
	public function importAllStockData()
	{
		$start = microtime(true);

		$watchedStocks = WatchedStock::where('isActive', true)
			->whereDate('imported_at', '<', Carbon::now()->setTime(0, 0, 0)->toDateTimeString())
			->get();

		foreach ($watchedStocks as $stock) {
			ImportHelpers::importStockData($stock->stockCode);
		}

		$end = microtime(true) - $start;

		return 'Done in ' . $end . ' sec';
	}
}
