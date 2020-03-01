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
        Schema::create('tbl_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('tbl_users');

            $table->integer('total_price')->default(0);
            $table->integer('total_points')->default(0);

            $table->string('name');
            $table->string('contact_number')->nullable();
            $table->longText('delivery_address');
            $table->longText('receipt')->nullable();
            $table->enum('status', ['PENDING', 'PROCESSING', 'PAID', 'CANCELLED', 'DELIVERED'])->nullable(); 
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
        Schema::dropIfExists('tbl_orders');
    }
}
