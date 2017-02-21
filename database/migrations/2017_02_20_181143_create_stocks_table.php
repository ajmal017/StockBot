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
            $table->float('9ema');
            $table->float('12ema');
            $table->float('26ema');
            $table->float('rsi');
            $table->float('PK');
            $table->float('PD');
            $table->float('slowPK');
            $table->float('slowPD');
            $table->timestamp('date');
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
