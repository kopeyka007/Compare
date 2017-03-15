<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('features', function (Blueprint $table) {
            $table->increments('features_id');                        
            $table->integer('features_pos');            
            $table->string('features_name');            
            $table->string('features_icon');            
            $table->string('features_desc');            
            $table->string('features_units');            
            $table->string('features_around');            
            $table->string('features_norm');            
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('features');                                
    }
}
