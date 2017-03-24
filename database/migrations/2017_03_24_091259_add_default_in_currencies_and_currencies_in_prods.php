<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDefaultInCurrenciesAndCurrenciesInProds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('currencies', function (Blueprint $table) {
            $table->boolean('currencies_default')->default(0)->nullable();
        });
        Schema::table('prods', function (Blueprint $table) {
            $table->integer('currencies_id')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prods', function (Blueprint $table) {
            $table->dropColumn('currencies_id');
        });
        Schema::table('currencies', function (Blueprint $table) {
            $table->dropColumn('currencies_default');
        });
    }
}
