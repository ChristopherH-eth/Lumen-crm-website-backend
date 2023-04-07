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
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name')->nullable(false);
            $table->string('last_name')->nullable(false);
            $table->string('salutation', 10)->nullable(true);
            $table->integer('account_id')->nullable(false)->unsigned();
            $table->string('title')->nullable(true);
            $table->string('reports_to')->nullable(true);
            $table->string('description')->nullable(true);
            $table->string('phone')->nullable(true);
            $table->string('email')->nullable(true);
            $table->boolean('email_opt_out')->nullable(false);
            $table->string('street')->nullable(true);
            $table->string('city')->nullable(true);
            $table->string('state_province')->nullable(true);
            $table->integer('zipcode')->nullable(true);
            $table->string('country')->nullable(true);
            $table->integer('user_id')->nullable(false)->unsigned();
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
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropForeign('contacts_account_id_foreign');
        });

        Schema::dropIfExists('contacts');
    }
};
