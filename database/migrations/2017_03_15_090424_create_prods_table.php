<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prods', function (Blueprint $table) {
            $table->increments('prods_id');            
            $table->integer('cats_id');            
            $table->integer('brands_id');            
            $table->integer('prods_pos');            
            $table->string('prods_name');            
            $table->string('prods_alias');
            $table->string('prods_foto');
            $table->string('prods_amazon');
            $table->float('prods_price', 8, 2);            
            $table->boolean('prods_active');            
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prods');                        
    }
}
