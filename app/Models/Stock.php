<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $stockCode
 * @property integer $open
 * @property integer $close
 * @property integer $high
 * @property integer $low
 * @property integer $volume
 * @property float $9ema
 * @property float $12ema
 * @property float $26ema
 * @property float $rsi
 * @property float $PK
 * @property float $PD
 * @property float $slowPK
 * @property float $slowPD
 * @property string $date
 * @property string $created_at
 * @property string $updated_at
 */
class Stock extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['stockCode', 'open', 'close', 'high', 'low', 'volume', '9ema', '12ema', '26ema', 'rsi', 'PK', 'PD', 'slowPK', 'slowPD', 'date', 'created_at', 'updated_at'];

}
