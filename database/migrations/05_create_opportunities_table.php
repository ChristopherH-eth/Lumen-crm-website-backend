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
        Schema::create('opportunities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('opportunity_name')->nullable(false);
            $table->string('type')->nullable(true);
            $table->boolean('follow_up')->nullable(false);
            $table->dateTime('close_date')->nullable(false);
            $table->string('stage')->nullable(false);
            $table->integer('probability')->nullable(true);
            $table->float('amount')->nullable(true);
            $table->string('lead_source')->nullable(true);
            $table->string('next_step')->nullable(true);
            $table->string('description', 4000)->nullable(true);
            $table->integer('user_id')->nullable(false)->unsigned();
            $table->integer('account_id')->nullable(false)->unsigned();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('opportunities');
    }
};
