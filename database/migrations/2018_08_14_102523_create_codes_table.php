<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('tbl_users');

            $table->integer('used_by_user_id')->nullable()->unsigned();
            $table->foreign('used_by_user_id')->references('id')->on('tbl_users');

            $table->string('code')->nullable();
            $table->enum('code_type', ['PAID', 'FREE'])->default('PAID');
            $table->enum('status', ['USED', 'UNUSED'])->default('UNUSED');
            $table->dateTime('owned_at')->nullable();
            $table->dateTime('used_at')->nullable();
            $table->dateTime('transfered_at')->nullable();
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
        Schema::dropIfExists('tbl_codes');
    }
}
