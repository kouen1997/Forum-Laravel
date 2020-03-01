<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCodesRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_code_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('requested_by_user_id')->nullable()->unsigned();
            $table->foreign('requested_by_user_id')->references('id')->on('tbl_users');


            $table->integer('quantity')->defaullt(0);
            $table->enum('status', ['PENDING', 'DONE', 'CANCELLED'])->default('PENDING');
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
        Schema::dropIfExists('tbl_code_requests');
    }
}
