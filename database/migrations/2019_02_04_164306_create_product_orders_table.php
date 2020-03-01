<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_product_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('tbl_users');

            $table->integer('product_id')->nullable()->unsigned();
            $table->foreign('product_id')->references('id')->on('tbl_products');

            $table->integer('price')->default(0);
            $table->integer('points')->default(0);
            $table->integer('quantity')->default(0);
            $table->integer('total_price')->default(0);
            $table->integer('total_points')->default(0);

            $table->string('name');
            $table->string('contact_number')->nullable();
            $table->longText('delivery_address');
            $table->longText('receipt')->nullable();
            $table->enum('status', ['PENDING', 'PAID', 'CANCELLED'])->nullable(); 
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
        Schema::dropIfExists('tbl_product_orders');
    }
}
