<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('price')->default(0);
            $table->integer('points')->default(0);
            $table->integer('stocks')->default(0);
            $table->string('image')->nullable();
            $table->longText('description')->nullable();
            $table->enum('type', ['NORMAL PRODUCT', 'RESELLER PRODUCT', 'STOCKIST PRODUCT'])->nullable();
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
        Schema::dropIfExists('tbl_products');
    }
}
