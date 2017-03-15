<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filters', function (Blueprint $table) {
            $table->increments('filters_id');            
            $table->integer('groups_id');            
            $table->integer('filters_pos');            
            $table->string('filters_name');            
            $table->string('filters_alias');            
            $table->string('filters_type');            
            $table->boolean('filters_filter');            
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('filters');        
    }
}
