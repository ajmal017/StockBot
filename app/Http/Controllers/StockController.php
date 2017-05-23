<?php

namespace App\Http\Controllers;

use App\Helpers\StockHelpers;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $data = [];
        $data['summary'] = $this->getSummaries();

        return view('index', ['data' => $data, 'page' => 'home']);
    }

    public function show($stockCode)
    {
        $data = [];
        $data['details'] = StockHelpers::getStockDetails($stockCode);

        return view('stock', ['data' => $data, 'page' => 'stock']);
    }

    private function getSummaries()
    {
        $results = [];
        $watchedStocks = StockHelpers::getWatchedStocks(true);

        foreach ($watchedStocks as $watchedStock) {
            $summary = StockHelpers::getStockSummary($watchedStock['stockCode']);
            $results[$watchedStock['stockCode']] = $summary;
        }

        return $results;
    }
}
