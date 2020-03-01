<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransferCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_transfer_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transfer_by_user_id')->nullable()->unsigned();
            $table->foreign('transfer_by_user_id')->references('id')->on('tbl_users');

            $table->integer('transfer_to_user_id')->nullable()->unsigned();
            $table->foreign('transfer_to_user_id')->references('id')->on('tbl_users');
            $table->string('code')->nullable();
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
        Schema::dropIfExists('tbl_transfer_codes');
    }
}
