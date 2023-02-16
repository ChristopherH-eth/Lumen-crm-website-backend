<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cryptocurrencies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('circulating_supply');
            $table->integer('cmc_rank');
            $table->string('date_added');
            $table->string('last_updated');
            $table->integer('max_supply');
            $table->string('name');
            $table->integer('num_market_pairs');
            $table->string('platform');
            $table->string('quote');
            $table->integer('self_reported_circulating_supply');
            $table->integer('self_reported_market_cap');
            $table->string('slug');
            $table->string('symbol');
            $table->string('tags');
            $table->integer('total_supply');
            $table->integer('tvl_ratio');
            $table->string('logo');
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
        Schema::dropIfExists('cryptocurrencies');
    }
};
