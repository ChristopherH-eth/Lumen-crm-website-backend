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
        Schema::create('leads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('salutation')->nullable(true);
            $table->string('first_name');
            $table->string('last_name');
            $table->string('company');
            $table->string('title')->nullable(true);
            $table->string('website')->nullable(true);
            $table->string('description')->nullable(true);
            $table->string('lead_status');
            $table->string('lead_owner');
            $table->string('phone')->nullable(true);
            $table->string('email')->nullable(true);
            $table->boolean('email_opt_out');
            $table->string('street')->nullable(true);
            $table->string('city')->nullable(true);
            $table->string('state_province')->nullable(true);
            $table->string('zipcode')->nullable(true);
            $table->string('country')->nullable(true);
            $table->integer('number_of_employees')->nullable(true);
            $table->integer('annual_revenue')->nullable(true);
            $table->string('lead_source')->nullable(true);
            $table->string('industry')->nullable(true);
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
        Schema::dropIfExists('leads');
    }
};
