<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemServiceCostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_service_cost', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('item_id')->default('0');
            $table->integer('service_id')->default('0');
            $table->decimal('cost',8,2)->default('0.0');
            $table->decimal('unit_price',8,2)->default('0.0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_service_cost');
    }
}
