<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $stockCode
 * @property integer $open
 * @property integer $close
 * @property integer $high
 * @property integer $low
 * @property integer $volume
 * @property float $macd
 * @property float $macdSignal
 * @property float $macdHistogram
 * @property float $rsi
 * @property float $percentK
 * @property float $percentD
 * @property boolean $isCounted
 * @property string $date
 * @property string $created_at
 * @property string $updated_at
 */
class Stock extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['stockCode', 'open', 'close', 'high', 'low', 'volume', 'macd', 'macdSignal', 'macdHistogram', 'rsi', 'stochK', 'stochD', 'date'];

    protected $hidden = ['created_at', 'updated_at'];
}
