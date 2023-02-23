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
        Schema::table('contacts', function (Blueprint $table) {
            $table->renameColumn('firstName', 'first_name');
            $table->renameColumn('lastName', 'last_name');
            $table->string('salutation', 10)->nullable(true)->before('created_at');
            $table->integer('account_name')->nullable(false)->before('created_at');
            $table->string('title')->nullable(true)->before('created_at');
            $table->string('reports_to')->nullable(true)->before('created_at');
            $table->string('description')->nullable(true)->before('created_at');
            $table->string('phone')->nullable(true)->before('created_at');
            $table->string('email')->nullable(true)->before('created_at');
            $table->boolean('email_opt_out')->nullable(true)->before('created_at');
            $table->string('street')->nullable(true)->before('created_at');
            $table->string('city')->nullable(true)->before('created_at');
            $table->string('state_province')->nullable(true)->before('created_at');
            $table->integer('zipcode')->nullable(true)->before('created_at');
            $table->string('country')->nullable(true)->before('created_at');
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
            $table->renameColumn('first_name', 'firstName');
            $table->renameColumn('last_name', 'lastName');
            $table->dropColumn('salutation');
            $table->dropColumn('account_Name');
            $table->dropColumn('title');
            $table->dropColumn('reports_to');
            $table->dropColumn('description');
            $table->dropColumn('phone');
            $table->dropColumn('email');
            $table->dropColumn('email_opt_out');
            $table->dropColumn('street');
            $table->dropColumn('city');
            $table->dropColumn('state_province');
            $table->dropColumn('zipcode');
            $table->dropColumn('country');
        });
    }
};
