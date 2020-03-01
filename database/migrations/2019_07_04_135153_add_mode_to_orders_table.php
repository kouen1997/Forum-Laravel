<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddModeToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_orders', function (Blueprint $table) {
            $table->integer('branch_id')->nullable()->unsigned()->after('user_id');
            $table->foreign('branch_id')->references('id')->on('tbl_users');
            $table->integer('quantity')->nullable()->after('branch_id');
            $table->enum('mode', ['PICKUP', 'DELIVERY'])->nullable()->after('congressional');
            $table->enum('order_type', ['BRONZE', 'SILVER', 'GOLD'])->nullable()->after('mode'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_orders', function (Blueprint $table) {
            //
        });
    }
}
