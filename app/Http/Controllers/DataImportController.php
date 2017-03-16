<?php

namespace App\Http\Controllers;

use App\Helpers\CsvHelper;
use App\Models\Stock;
use App\Models\WatchedStock;
use Carbon\Carbon;
use GuzzleHttp\Client;
use LupeCode\phpTraderInterface\Trader;

class DataImportController extends Controller
{
	const HISTORICAL_PRICE_URL = 'http://www.google.com/finance/historical?q=IDX%3A{stock}&output=csv';
	const MAX_STOCK_ROWS = 50;
	const OFFSET_ROWS = 35;

	/*
	 * stock data will be in this format
	 * date - open - high - low - close - volume
	 */
    public function importStockData()
    {
    	$start = microtime(true);

    	Stock::truncate();

    	$watchedStocks = WatchedStock::where('isActive', true)->get();

			$client = new Client();

			foreach ($watchedStocks as $stock) {
				$response = $client->request('GET', $this->getStockDataUrl($stock->stockCode));
				$csv = $response->getBody()->getContents();

				$data = $this->getLastNArray(array_reverse(CsvHelper::csvToArray($csv)), self::MAX_STOCK_ROWS + self::OFFSET_ROWS);
				$rows = $this->getLastNArray($this->calculateData($data, $stock->stockCode), self::MAX_STOCK_ROWS);

				foreach ($rows as $row) {
					$check = Stock::where('stockCode', $stock->stockCode)->whereDate('date', '=', $row['date'])->count();

					if ($check == 0) {
						Stock::create($row);
					}
				}
			}
	
			$end = microtime(true) - $start;
	
			return 'Done in ' . $end . ' sec';
    }

    public function calculateData(array $rows, $stockCode)
    {
    	$details = $this->getDetails($rows);
			$macds = Trader::macd($details['close'], 12, 26, 9);
			$rsis = Trader::relativeStrengthIndex($details['close'], 14);
			$stochastics = Trader::stoch($details['high'], $details['low'], $details['close'], 14, 3);
	
			$result = [];

    	for ($i = 0; $i < count($rows); $i++)
	    {
	    	$row = $rows[$i];

	    	array_push($result, [
	    		'stockCode' => $stockCode,
			    'date' => $row[0],
			    'open' => $row[1],
			    'high' => $row[2],
			    'low' => $row[3],
			    'close' => $row[4],
			    'volume' => $row[5],
					'macd' => $macds[0][$i] ?? 0,
			    'macdSignal' => $macds[1][$i] ?? 0,
			    'macdHistogram' => $macds[2][$i] ?? 0,
			    'rsi' => $rsis[$i] ?? 0,
			    'stochK' => $stochastics[0][$i] ?? 0,
			    'stochD' => $stochastics[1][$i] ?? 0
		    ]);
	    }

	    return $result;
    }

    private function getLastNArray(array $rows, $count)
    {
        return array_slice($rows, count($rows) - $count, $count);
	}

    private function getDetails(array $rows)
    {
    	$highs = [];
    	$lows = [];
    	$closes = [];

    	foreach ($rows as $row) {
			array_push($highs, $row[2]);
		    array_push($lows, $row[3]);
		    array_push($closes, $row[4]);
	    }

	    return [
	    	'high' => $highs,
		    'low' => $lows,
		    'close' => $closes
	    ];
    }

    private function getStockDataUrl($stock)
    {
    	return str_replace("{stock}", $stock, self::HISTORICAL_PRICE_URL);
    }
}
