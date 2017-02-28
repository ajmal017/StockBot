<?php

namespace App\Http\Controllers;

use App\Helpers\CsvHelper;
use App\Helpers\OscillatorHelper;
use App\Stock;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class DataImportController extends Controller
{
	const HISTORICAL_PRICE_URL = 'http://www.google.com/finance/historical?q=IDX%3A{stock}&output=csv';
	const MAX_STOCK_ROWS = 80;

	/*
	 * stock data will be in this format
	 * date - open - high - low - close - volume
	 */
    public function importStockData()
    {
    	$start = microtime(true);
	    $stockCode = 'WIKA';

		$client = new Client();
		$response = $client->get($this->getStockDataUrl($stockCode));
		$csv = $response->getBody()->getContents();

		$data = array_slice(CsvHelper::csvToArray($csv), 0, self::MAX_STOCK_ROWS);
		$rows = $this->setKeyFromArray($data, $stockCode);

		$rows = array_reverse($rows);
		foreach ($rows as $row)
		{
			$check = Stock::where('stockCode', $stockCode)->where('date', $row['date'])->count();

			if ($check == 0) {
				Stock::create($row);
			}
		}

		$end = microtime(true) - $start;
		return 'done in ' . $end;
    }

    public function setKeyFromArray(array $rows, $stockCode)
    {
    	$result = [];

    	foreach ($rows as $row)
	    {
	    	array_push($result, [
	    		'stockCode' => $stockCode,
			    'date' => $row[0],
			    'open' => $row[1],
			    'high' => $row[2],
			    'low' => $row[3],
			    'close' => $row[4],
			    'volume' => $row[5]
		    ]);
	    }

	    return $result;
    }

    public function calculateOscillator(array &$rows)
    {
		foreach ($rows as $key => &$row) {
			$row['PK'] = OscillatorHelper::stochasticK(array_slice($rows, $key, min(14, count($rows) - $key)));
			//$row['ema9'] = OscillatorHelper::ema9()
        }
    }

    private function getStockDataUrl($stock)
    {
    	return str_replace("{stock}", $stock, self::HISTORICAL_PRICE_URL);
    }
}
