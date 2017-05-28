<?php
/**
 * Created by PhpStorm.
 * User: srz
 * Date: 5/23/2017
 * Time: 8:46 AM
 */

namespace App\Helpers;


use App\Models\Stock;
use App\Models\WatchedStock;

class StockHelpers
{
    const SUMMARY_COUNT = 12;
    const DETAIL_COUNT = 50;
    const DEFAULT_DATE_ORDER = 'desc';

    public static function getWatchedStocks($isActive)
    {
        return WatchedStock::where('isActive', $isActive)
	        ->orderBy('stockCode', 'asc')
            ->get()
            ->toArray();
    }

    public static function getStockSummary($stockCode)
    {
        $stocks = self::getStockData($stockCode)
            ->take(self::SUMMARY_COUNT)
            ->get()
            ->toArray();

        return self::dataToResult($stocks, self::SUMMARY_COUNT);
    }

    public static function getStockDetails($stockCode)
    {
        $stocks = self::getStockData($stockCode)
            ->take(self::DETAIL_COUNT)
            ->get()
            ->toArray();

        return self::dataToResult($stocks, self::DETAIL_COUNT - 1);
    }

    private static function getStockData($stockCode)
    {
        return Stock::where('stockCode', $stockCode)
            ->orderBy('date', self::DEFAULT_DATE_ORDER);
    }

    private static function dataToResult(array $array, $count)
    {
        $results = self::processResults($array);
	    $results = self::processInsight($results, $count);
	    $results = self::processPrices($results, $array);
        $results = self::encodeResults($results);

        return $results;
    }

    private static function encodeResults(array $results)
    {
	    $results['rsi'] = json_encode($results['rsi']);
	    $results['macd'] = json_encode($results['macd']);
	    $results['stoch'] = json_encode($results['stoch']);

	    return $results;
    }

    private static function processPrices(array $results, array $array)
    {
    	$results['historicPrices'] = [];

    	for ($i = count($array) - 1; $i >= 0; $i--) {
    		$item = $array[$i];
    		array_push($results['historicPrices'], [$item['date'], $item['low'], $item['open'], $item['close'], $item['high']]);
	    }

	    $results['historicPrices'] = json_encode($results['historicPrices']);

	    return $results;
    }

    private static function processResults(array $array)
    {
	    $results = [
	    	'stockCode' => $array[0]['stockCode'],
		    'price' => $array[0]['close'],
		    'change' => sprintf('%+d', $array[0]['close'] - $array[1]['close']),
		    'percent' => number_format(($array[0]['close'] - $array[1]['close']) / $array[1]['close'], 2),
		    'rsi' => [['date', 'RSI']],
		    'macd' => [['date', 'MACD', 'SIGNAL', 'HISTOGRAM']],
		    'stoch' => [['date', '%K', '%D']]
	    ];

	    for ($i = count($array) - 1; $i >= 0; $i--) {
		    $item = $array[$i];

		    array_push($results['rsi'], [$item['date'], $item['rsi']]);
		    array_push($results['macd'], [$item['date'], $item['macd'], $item['macdSignal'], $item['macdHistogram']]);
		    array_push($results['stoch'], [$item['date'], $item['stochK'], $item['stochD']]);
	    }

	    return $results;
    }

    private static function processInsight($results, $count)
    {
        $rsi = $results['rsi'][$count][1];

        $macdHistogram = [
            $results['macd'][$count][3],
            $results['macd'][$count - 1][3]
        ];

        $stoch = $results['stoch'][$count][1];
        $stochHistogram = [
            $results['stoch'][$count][1] - $results['stoch'][$count][2],
            $results['stoch'][$count - 1][1] - $results['stoch'][$count - 1][2]
        ];

        $results['insight'] = [
	        'rsi' => self::getRsiInsight($rsi),
	        'macd' => self::getMacdInsight($macdHistogram),
	        'stoch' => self::getStochInsight($stoch, $stochHistogram)
        ];

        $results['overall'] = $results['insight']['rsi']['score'] + $results['insight']['macd']['score'] + $results['insight']['stoch']['score'];

        return $results;
    }

    private static function getRsiInsight($rsi) {
        if ($rsi > 70) {
            return ['label' => 'label-danger', 'chart' => 'danger', 'text' => 'SELL', 'score' => -2];
        } else if ($rsi < 30) {
            return ['label' => 'label-success', 'chart' => 'success', 'text' => 'BUY', 'score' => 2];
        }
        return ['label' => 'label-default', 'chart' => '', 'text' => 'HOLD', 'score' => 0];
    }

    private static function getMacdInsight($macd) {
        if ($macd[0] < 0 && $macd[1] >= 0) {
            return ['label' => 'label-danger', 'chart' => 'danger', 'text' => 'SELL', 'score' => -1];
        } else if ($macd[0] > 0 && $macd[1] <= 0) {
            return ['label' => 'label-success', 'chart' => 'success', 'text' => 'BUY', 'score' => 1];
        }
	    return ['label' => 'label-default', 'chart' => '', 'text' => 'HOLD', 'score' => 0];
    }

    private static function getStochInsight($stoch, $stochHistogram) {
        if ($stochHistogram[0] < 0 && $stochHistogram[1] >= 0 && $stoch > 70) {
	        return ['label' => 'label-danger', 'chart' => 'danger', 'text' => 'SELL', 'score' => -1];
        } else if ($stochHistogram[0] > 0 && $stochHistogram[1] <= 0 && $stoch < 30) {
	        return ['label' => 'label-success', 'chart' => 'success', 'text' => 'BUY', 'score' => 1];
        }
	    return ['label' => 'label-default', 'chart' => '', 'text' => 'HOLD', 'score' => 0];
    }
}