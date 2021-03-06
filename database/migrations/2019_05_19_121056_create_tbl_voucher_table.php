<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblVoucherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_voucher', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('tbl_users');
            $table->string('code')->nullable();
            $table->integer('counter')->default(0);
            $table->enum('voucher_type', ['BRONZE', 'SILVER', 'GOLD'])->nullable();
            $table->enum('status', ['UNUSED', 'USED'])->nullable();
            $table->timestamps();

            $table->index(['code', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_voucher');
    }
}
