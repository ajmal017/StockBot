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
	private $data;

	public function __construct()
	{
		$this->data['lastUpdated'] = WatchedStock::orderBy('importedAt', 'asc')->first()->importedAt;
	}

	public function index()
    {
        $this->data['summary'] = $this->getSummaries();

        return view('index', ['data' => $this->data, 'page' => 'home']);
    }

    public function show($stockCode)
    {
	    $this->data['details'] = StockHelpers::getStockDetails($stockCode);

        return view('stock', ['data' => $this->data, 'page' => 'stock']);
    }

    public function store(Request $request)
    {
		$data = $request->only(['stockCode']);
		$data['stockCode'] = strtoupper($data['stockCode']);
		$data['imported_at'] = Carbon::now();

		$stock = WatchedStock::where('stockCode', $data['stockCode'])->first();

		if (!isset($stock)) {
			DB::transaction(function () use ($data) {
				WatchedStock::create($data);

				ImportHelpers::importStockData($data['stockCode']);
			});
		}

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

        uasort($results, function($a, $b) {
        	return $b['overall'] - $a['overall'];
        });

        return $results;
    }
}
