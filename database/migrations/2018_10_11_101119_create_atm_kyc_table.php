<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAtmKycTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_atm_kyc', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('tbl_users');
            $table->string('user_username');

            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name');
            $table->string('mother_maiden_name');
            $table->string('card_name');
            $table->string('home_address');
            $table->string('email');
            $table->date('birth_date');
            $table->enum('gender', ['MALE', 'FEMALE']);
            $table->enum('civil_status', ['SINGLE', 'MARRIED', 'WIDOWED']);
            $table->integer('dependents');
            $table->string('citizenship');
            $table->string('mobile_number');
            $table->enum('employed', ['YES', 'NO']);
            $table->string('source_of_fund')->nullable(); 
            $table->string('position')->nullable();
            $table->decimal('annual_income', 15, 2); 
            $table->longText('employer_name')->nullable();
            $table->longText('employer_address')->nullable();
            $table->string('submitted_id')->nullable();
            $table->string('submitted_id_no')->nullable();
            $table->longText('shipping_address')->nullable();
            $table->enum('status', ['PROCESSING', 'DENIED', 'APPROVED']);
            $table->boolean('approved')->default(0);
            $table->longText('note')->nullable();

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
        Schema::dropIfExists('tbl_atm');
    }
}
