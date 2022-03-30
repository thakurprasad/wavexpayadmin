<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentblocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contentblocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 150);      
            $table->string('aliases', 150)->nullable();               
            $table->longText('content')->nullable(); 
            $table->enum('status', ['Active', 'Inactive'])->default('Inactive');
            $table->integer('position')->default('0'); 
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
        Schema::dropIfExists('contentblocks');
    }
}
