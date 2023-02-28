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
            $table->string('description')->nullable(true);
            $table->integer('parent_account')->nullable(true);
            $table->string('account_owner')->nullable(false);
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
        Schema::dropIfExists('accounts');
    }
};
