<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_order_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->index();

            $table->integer('product_id')->nullable()->unsigned();
            $table->foreign('product_id')->references('id')->on('tbl_products');

            $table->integer('price')->default(0);
            $table->integer('points')->default(0);
            $table->integer('quantity')->default(0);

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
        Schema::dropIfExists('tbl_order_products');
    }
}
