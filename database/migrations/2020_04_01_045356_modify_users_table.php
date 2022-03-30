<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 20)->nullable()->after('password');
            $table->string('address_1', 255)->nullable()->after('phone');
            $table->string('address_2', 255)->nullable()->after('address_1');
            $table->string('city', 150)->nullable()->after('address_2');
            $table->string('state', 150)->nullable()->after('city');
            $table->string('pincode', 15)->nullable()->after('state');
            $table->integer('country')->default('0')->after('pincode');
            $table->integer('is_recruiter')->default('0'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
