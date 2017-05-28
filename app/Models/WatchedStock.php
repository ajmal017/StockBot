<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $stockCode
 * @property boolean $isActive
 * @property string $created_at
 * @property string $updated_at
 */
class WatchedStock extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['stockCode', 'isActive', 'importedAt'];

	protected $hidden = ['created_at', 'updated_at'];

}
