<?php

namespace App\Http\Controllers;

use App\Helpers\ImportHelpers;
use App\Helpers\StockHelpers;
use App\Models\WatchedStock;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function store(Request $request)
    {
		$data = $request->only(['stockCode']);
		$data['stockCode'] = strtoupper($data['stockCode']);
		$data['imported_at'] = Carbon::now();

		DB::transaction(function () use ($data) {
			WatchedStock::create($data);

			ImportHelpers::importStockData($data['stockCode']);
		});

		return redirect()->back();
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
