<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('branch_id')->default('0');
            $table->integer('customer_id')->default('0');
            $table->integer('customer_mobile')->default('0');
            $table->decimal('order_total',8,2)->default('0.00');
            $table->integer('order_status_id')->default('0');
            $table->date('received_on')->nullable();
            $table->date('expected_delivery')->nullable();
            $table->string('created_by', 150)->nullable();
            $table->timestamps();
        });

        Schema::create('order_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('order_id')->default('0');
            $table->string('item_name', 150)->nullable();
            $table->string('service_name', 150)->nullable();
            $table->decimal('item_service_cost',8,2)->default('0.00');
            $table->integer('quantity')->default('0');
            $table->decimal('unit_price',8,2)->default('0.00');
            $table->decimal('item_total',8,2)->default('0.00');
            $table->integer('item_status_id')->default('0');
            $table->string('created_by', 150)->nullable();
            $table->timestamps();
        });

        Schema::create('order_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('order_id')->default('0');
            $table->integer('branch_id')->default('0');
            $table->string('payment_mode', 150)->nullable();
            $table->decimal('paid_amount',8,2)->default('0.00');
            $table->string('payment_note', 150)->nullable();
            $table->string('created_by', 150)->nullable();
            $table->timestamps();
        });

        Schema::create('order_activities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('order_id')->default('0');
            $table->integer('branch_id')->default('0');
            $table->integer('order_detail_id')->default('0');
            $table->string('description', 150)->nullable();
            $table->string('order_status', 150)->nullable();
            $table->string('created_by', 150)->nullable();
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
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_details');
        Schema::dropIfExists('order_payments');
        Schema::dropIfExists('order_activities');
    }
}
