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
            $table->renameColumn('account_name', 'account_id');
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->integer('account_id')->unsigned()->change();
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
            $table->renameColumn('account_id', 'account_name');
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->integer('account_id')->signed()->change();
            $table->dropForeign('contacts_account_id_foreign');
        });
    }
};
