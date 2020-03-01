<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRetrieveCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_retrieve_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('retrieve_by_user_id')->nullable()->unsigned();
            $table->foreign('retrieve_by_user_id')->references('id')->on('tbl_users');

            $table->integer('retrieve_from_user_id')->nullable()->unsigned();
            $table->foreign('retrieve_from_user_id')->references('id')->on('tbl_users');
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
        Schema::dropIfExists('tbl_retrieve_codes');
    }
}
