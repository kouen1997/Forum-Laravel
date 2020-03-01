<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGenealogyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_genealogy', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('tbl_users');
            $table->integer('account_id')->nullable()->unsigned();
            $table->foreign('account_id')->references('id')->on('tbl_accounts');
            $table->integer('downline_id')->nullable()->unsigned();
            $table->foreign('downline_id')->references('id')->on('tbl_accounts');
            $table->boolean('position');  
            $table->integer('level');
            $table->boolean('status');  
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
        Schema::dropIfExists('tbl_genealogy');
    }
}
