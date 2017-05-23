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
    const DEFAULT_DATE_ORDER = 'desc';

    public static function getWatchedStocks($isActive)
    {
        return WatchedStock::where('isActive', $isActive)
            ->get()
            ->toArray();
    }

    public static function getStockSummary($stockCode)
    {
        $stocks = self::getStockData($stockCode)
            ->take(self::SUMMARY_COUNT)
            ->get()
            ->toArray();

        return self::dataToResult($stocks);
    }

    public static function getStockPrices($stockCode)
    {
        return self::getStockData($stockCode)
            ->get()
            ->toArray();
    }

    private static function getStockData($stockCode)
    {
        return Stock::where('stockCode', $stockCode)
            ->orderBy('date', self::DEFAULT_DATE_ORDER);
    }

    private static function dataToResult(array $array)
    {
        $results = [
            'price' => $array[0]['close'],
            'change' => sprintf('%+d', $array[0]['close'] - $array[1]['close']),
            'percent' => number_format(($array[0]['close'] - $array[1]['close']) / $array[1]['close'], 2),
            'rsi' => [['date', 'rsi']],
            'macd' => [['date', 'macd', 'signal', 'histogram']],
            'stochastic' => [['date', 'k', 'd']]
        ];

        for ($i = count($array) - 1; $i >= 0; $i--) {
            $item = $array[$i];

            array_push($results['rsi'], [$item['date'], $item['rsi']]);
            array_push($results['macd'], [$item['date'], $item['macd'], $item['macdSignal'], $item['macdHistogram']]);
            array_push($results['stochastic'], [$item['date'], $item['stochK'], $item['stochD']]);
        }

        $results['rsi'] = json_encode($results['rsi']);
        $results['macd'] = json_encode($results['macd']);
        $results['stochastic'] = json_encode($results['stochastic']);

        return $results;
    }
}