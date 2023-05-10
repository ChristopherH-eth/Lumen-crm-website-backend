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
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('account_name')->nullable(false);
            $table->string('website')->nullable(true);
            $table->string('type')->nullable(true);
            $table->string('description', 4000)->nullable(true);
            $table->integer('parent_account')->nullable(true);
            $table->string('phone')->nullable(true);
            $table->string('billing_street')->nullable(true);
            $table->string('billing_city')->nullable(true);
            $table->string('billing_state_province')->nullable(true);
            $table->string('billing_zipcode')->nullable(true);
            $table->string('billing_country')->nullable(true);
            $table->string('shipping_street')->nullable(true);
            $table->string('shipping_city')->nullable(true);
            $table->string('shipping_state_province')->nullable(true);
            $table->string('shipping_zipcode')->nullable(true);
            $table->string('shipping_country')->nullable(true);
            $table->integer('user_id')->nullable(false)->unsigned();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
};
