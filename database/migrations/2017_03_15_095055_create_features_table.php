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
            $table->integer('features_pos')->default(0);            
            $table->string('features_name');            
            $table->string('features_icon')->default('')->nullable();         
            $table->string('features_desc')->default('')->nullable();
            $table->string('features_units')->default('')->nullable();            
            $table->string('features_around')->default('')->nullable();            
            $table->string('features_norm')->default('')->nullable();            
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
