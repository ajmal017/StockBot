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
            $table->float('macd')->default(0);
	        $table->float('macdSignal')->default(0);
            $table->float('macdHistogram')->default(0);
            $table->float('rsi')->default(0);
            $table->float('stochK')->default(0);
            $table->float('stochD')->default(0);
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
