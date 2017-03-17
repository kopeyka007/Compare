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
            $table->integer('brands_id')->nullable();            
            $table->integer('prods_pos')->default(0);            
            $table->string('prods_name');            
            $table->string('prods_alias');
            $table->string('prods_foto')->default('')->nullable();
            $table->string('prods_amazon')->default('')->nullable();
            $table->float('prods_price', 8, 2)->nullable();            
            $table->boolean('prods_active')->default(false);            
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
