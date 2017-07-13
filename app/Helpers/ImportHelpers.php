<?php


namespace App\Helpers;

use App\Models\Stock;
use App\Models\WatchedStock;
use Carbon\Carbon;
use GuzzleHttp\Client;
use LupeCode\phpTraderInterface\Trader;

class ImportHelpers
{
	const HISTORICAL_PRICE_URL = 'http://www.google.com/finance/historical?q=IDX%3A{stock}&output=csv';
	const MAX_STOCK_ROWS = 50;
	const OFFSET_ROWS = 35;

	public static function importStockData($stockCode)
	{
		Stock::where('stockCode', $stockCode)->delete();

		$client = new Client();
		$response = $client->request('GET', self::getStockDataUrl($stockCode));
		$csv = $response->getBody()->getContents();

		$data = self::getLastNArray(array_reverse(CsvHelpers::csvToArray($csv)), self::MAX_STOCK_ROWS + self::OFFSET_ROWS);
		$rows = self::getLastNArray(self::calculateData($data, $stockCode), self::MAX_STOCK_ROWS);

		foreach ($rows as $row) {
			Stock::create($row);
		}

		$watchedStock = WatchedStock::where('stockCode', $stockCode)->first();
		$watchedStock->importedAt = Carbon::now();

		$watchedStock->save();
	}

	public static function calculateData(array $rows, $stockCode)
	{
		$details = self::getDetails($rows);
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
				'high' => is_numeric($row[2]) ? $row[2] : max($row[1], $row[4]),
				'low' => is_numeric($row[3]) ? $row[3] : min($row[1], $row[4]),
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

	private static function getLastNArray(array $rows, $count)
	{
		return array_slice($rows, count($rows) - $count, $count);
	}

	private static function getDetails(array $rows)
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

	private static function getStockDataUrl($stock)
	{
		return str_replace("{stock}", $stock, self::HISTORICAL_PRICE_URL);
	}
}