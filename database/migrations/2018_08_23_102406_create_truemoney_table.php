<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTruemoneyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_truemoney', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('tbl_users');

            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('name_suffix');
            $table->string('email');
            $table->string('card_number');
            $table->string('mobile_number');
            $table->string('gender');
            $table->date('birth_date')->nullable();
            $table->string('birth_place')->nullable();
            $table->string('nationality');
            $table->string('mother_name');
            $table->string('house_no')->nullable();
            $table->string('street')->nullable();
            $table->string('village')->nullable();
            $table->string('barangay')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('affiliated')->nullable();
            $table->string('occupation')->nullable();
            $table->string('source_of_fund')->nullable();
            $table->string('employer_username')->nullable();
            $table->string('gov_id')->nullable();
            $table->string('gov_id_number')->nullable();
            $table->string('order_address')->nullable();
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
        Schema::dropIfExists('tbl_truemoney');
    }
}
