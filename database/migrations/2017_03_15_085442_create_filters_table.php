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
            $table->integer('filters_pos')->default(0);            
            $table->string('filters_name');            
            $table->string('filters_alias')->default('')->nullable();            
            $table->string('filters_type')->default('')->nullable();            
            $table->boolean('filters_filter')->default(0);            
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
