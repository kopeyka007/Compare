<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoryTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_single', function (Blueprint $table) {
            $table->increments('rows_id');                        
            $table->integer('prods_id');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        }); 
        Schema::create('history_pairs', function (Blueprint $table) {
            $table->increments('rows_id');                        
            $table->integer('prods1_id');
            $table->integer('prods2_id');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
        Schema::create('history_amazon', function (Blueprint $table) {
            $table->increments('rows_id');                        
            $table->integer('prods_id');
            $table->string('prods_amazon');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        }); 
        Schema::create('history_compare', function (Blueprint $table) {
            $table->increments('rows_id');                        
            $table->integer('cats_id');
            $table->string('compare_link');            
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('history_single');                        
        Schema::dropIfExists('history_pairs');                        
        Schema::dropIfExists('history_amazon');                        
        Schema::dropIfExists('history_compare');                        
    }
}
