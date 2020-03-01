<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblInquiryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_inquiry', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('tbl_users');
            $table->bigInteger('property_id')->nullable()->unsigned();
            $table->foreign('property_id')->references('id')->on('tbl_properties');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->longText('message')->nullable();
            $table->longText('note')->nullable();
            $table->enum('status', ['PENDING', 'TO FOLLOW', 'COMPLETED'])->nullable();
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
        Schema::dropIfExists('tbl_inquiry');
    }
}
