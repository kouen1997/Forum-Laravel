<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTruemoneyWithdrawalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_truemoney_withdrawals', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('tbl_users');

            $table->string('user_username')->nullable();
            $table->decimal('amount', 15, 2);
            $table->longText('details')->nullable();
            $table->enum('mode', ['NONE', 'TRUEMONEY'])->nullable();
            $table->integer('transact_by_id')->nullable(); 
            $table->string('transact_by_username')->nullable(); 
            $table->dateTime('transact_at')->nullable();
            $table->dateTime('cancelled_at')->nullable();
            $table->string('cancelled_by')->nullable(); 
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
        Schema::dropIfExists('tbl_truemoney_withdrawals');
    }
}
