<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdsFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prods_filters', function (Blueprint $table) {
            $table->increments('rows_id');                        
            $table->integer('prods_id');            
            $table->integer('filters_id');                        
            $table->string('filters_value');                        
            $table->string('filters_comment');                        
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prods_filters');        
    }
}
