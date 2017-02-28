<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->char('stockCode', 8);
            $table->integer('open');
            $table->integer('close');
            $table->integer('high');
            $table->integer('low');
            $table->bigInteger('volume');
            $table->float('ema9')->default(0);
            $table->float('ema12')->default(0);
            $table->float('ema26')->default(0);
            $table->float('macd')->default(0);
            $table->float('macdHistogram')->default(0);
            $table->float('rsi')->default(0);
            $table->float('PK')->default(0);
            $table->float('PD')->default(0);
            $table->float('slowPK')->default(0);
            $table->float('slowPD')->default(0);
            $table->boolean('isCounted')->default(false);
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocks');
    }
}
