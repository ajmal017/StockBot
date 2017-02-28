<?php

namespace App\Helpers;

class OscillatorHelper
{
	/*
	 * $data is consist of several keys
	 * ['date', 'high', 'low', 'open', 'close', 'volume']
	 */

	public static function stochasticK(array $rows)
	{
		$lowest14 = $rows[0]['low'];
		$highest14 = $rows[0]['high'];
		$closing = $rows[0]['close'];

		foreach ($rows as $row) {
			if ($row['low'] < $lowest14) {
				$lowest14 = $row['low'];
			}
			if ($row['high'] < $highest14) {
				$highest14 = $row['high'];
			}
		}

		return (100 * ($closing - $lowest14) / ($highest14 - $lowest14));
	}

	public static function stochasticD(array $rows)
	{
		foreach ($rows as $row) {

		}
	}

	public static function ema9(array $rows)
	{

	}

	public static function ema12(array $rows)
	{

	}

	public static function ema26(array $rows)
	{

	}

	public static function relativeStrengthIndex(array $data)
	{

	}

	public static function movingAverageConvergenceDivergence(array $data)
	{

	}
}