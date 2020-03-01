<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoadTransferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_load_transfer', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transfer_by_user_id')->nullable()->unsigned();
            $table->foreign('transfer_by_user_id')->references('id')->on('tbl_users');

            $table->integer('transfer_to_user_id')->nullable()->unsigned();
            $table->foreign('transfer_to_user_id')->references('id')->on('tbl_users');
            $table->double('amount')->default(0);
            $table->double('total')->default(0);
            $table->boolean('wallet')->default(0);  
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
        Schema::dropIfExists('tbl_load_transfer');
    }
}
