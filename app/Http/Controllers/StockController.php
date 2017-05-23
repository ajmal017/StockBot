<?php

namespace App\Http\Controllers;

use App\Helpers\StockHelpers;
use App\Models\Stock;
use App\Models\WatchedStock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $data = [];
        $data['summary'] = $this->getSummaries();

        return view('index', ['data' => $data]);
    }

    private function getSummaries()
    {
        $results = [];
        $watchedStocks = StockHelpers::getWatchedStocks(true);

        foreach ($watchedStocks as $watchedStock) {
            // Summary
            $summary = StockHelpers::getStockSummary($watchedStock['stockCode']);
            $results[$watchedStock['stockCode']] = $summary;
        }

        return $results;
    }
}
