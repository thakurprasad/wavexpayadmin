<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCustomerInfoToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('customer_name','150')->nullable()->after('customer_id');
            $table->string('address','255')->nullable()->after('customer_name');
            $table->string('locality','255')->nullable()->after('address');
            $table->string('bill_number','100')->nullable()->after('branch_id');
            $table->string('order_note','100')->nullable()->after('locality');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}
