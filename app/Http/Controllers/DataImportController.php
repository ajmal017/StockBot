<?php

namespace App\Http\Controllers;

use App\Helpers\ImportHelpers;
use App\Helpers\StockHelpers;
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

		$watchedStocks = StockHelpers::getUnimportedWatchedStocks();
		$index = 0;

		while (microtime(true) - $start < 29 && $index < count($watchedStocks))
		{
			$stock = $watchedStocks[$index];
			ImportHelpers::importStockData($stock['stockCode']);
			$index++;
		}

		$end = microtime(true) - $start;

		return 'Done in ' . $end . ' sec';
	}
}
