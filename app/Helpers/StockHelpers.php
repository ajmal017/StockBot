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

    public static function getStockDetails($stockCode)
    {
        $stocks = self::getStockData($stockCode)
            ->take(self::DETAIL_COUNT)
            ->get()
            ->toArray();

        return self::dataToResult($stocks);
    }

    private static function getStockData($stockCode)
    {
        return Stock::where('stockCode', $stockCode)
            ->orderBy('date', self::DEFAULT_DATE_ORDER);
    }

    private static function dataToDetail(array $array)
    {

    }

    private static function dataToResult(array $array)
    {
        $results = [
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

        $results['insight'] = self::processInsight($results);

        $results['rsi'] = json_encode($results['rsi']);
        $results['macd'] = json_encode($results['macd']);
        $results['stoch'] = json_encode($results['stoch']);

        return $results;
    }

    private static function processInsight($results)
    {
        $lastRsi = $results['rsi'][self::SUMMARY_COUNT][1];
        $lastMacd = [
            $results['macd'][self::SUMMARY_COUNT][3],
            $results['macd'][self::SUMMARY_COUNT - 1][3]
        ];
        $lastStoch = [
            $results['stoch'][self::SUMMARY_COUNT][1] - $results['stoch'][self::SUMMARY_COUNT][2],
            $results['stoch'][self::SUMMARY_COUNT - 1][1] - $results['stoch'][self::SUMMARY_COUNT - 1][2]
        ];

        return [
            'rsi' => self::getRsiInsight($lastRsi),
            'macd' => self::getMacdInsight($lastMacd),
            'stoch' => self::getStochInsight($lastStoch)
        ];
    }

    private static function getRsiInsight($rsi) {
        if ($rsi > 70) {
            return ['label' => 'label-danger', 'chart' => 'danger', 'text' => 'SELL'];
        } else if ($rsi < 30) {
            return ['label' => 'label-success', 'chart' => 'success', 'text' => 'BUY'];
        }
        return ['label' => 'label-default', 'chart' => '', 'text' => 'HOLD'];
    }

    private static function getMacdInsight($macd) {
        if ($macd[0] < 0 && $macd[1] >= 0) {
            return ['label' => 'label-danger', 'chart' => 'danger', 'text' => 'SELL'];
        } else if ($macd[0] > 0 && $macd[1] <= 0) {
            return ['label' => 'label-success', 'chart' => 'success', 'text' => 'BUY'];
        }
        return ['label' => 'label-default', 'chart' => '', 'text' => 'HOLD'];
    }

    private static function getStochInsight($stoch) {
        if ($stoch[0] < 0 && $stoch[1] >= 0) {
            return ['label' => 'label-danger', 'chart' => 'danger', 'text' => 'SELL'];
        } else if ($stoch[0] > 0 && $stoch[1] <= 0) {
            return ['label' => 'label-success', 'chart' => 'success', 'text' => 'BUY'];
        }
        return ['label' => 'label-default', 'chart' => '', 'text' => 'HOLD'];
    }
}