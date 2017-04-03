<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoryFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_filters', function (Blueprint $table) {
            $table->increments('rows_id');                        
            $table->integer('compare_id');
            $table->integer('prods_id');
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
    }
}
