<?php

namespace App\Helpers;

use Carbon\Carbon;

class CsvHelper
{
	public static function csvToArray($csv)
	{
		$rows = explode("\n", $csv);
		array_shift($rows);
		array_pop($rows);

		foreach ($rows as &$row) {
			$row = explode(",", $row);
			// Parse date
			$row[0] = Carbon::createFromFormat("d-M-y", $row[0])->toDateString();
		}

		return $rows;
	}
}