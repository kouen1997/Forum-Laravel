<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('tbl_users');
            $table->string('account_name')->nullable()->unique();
            $table->string('activation_code')->nullable()->unique();
            $table->integer('parent_id')->nullable();
            $table->integer('parent_user_id')->nullable()->unsigned();
            $table->foreign('parent_user_id')->references('id')->on('tbl_users');
            $table->string('parent_account_name')->nullable();
            $table->enum('position', ['LEFT', 'RIGHT'])->nullable();
            $table->bigInteger('total_left')->default(0);
            $table->bigInteger('total_right')->default(0);
            $table->bigInteger('waiting_left')->default(0);
            $table->bigInteger('waiting_right')->default(0);
            $table->enum('status', ['PAID', 'FREE SLOT'])->nullable();
            $table->boolean('optimize')->default(0);   
            $table->timestamps();

            $table->index(['account_name', 'activation_code']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_accounts');
    }
}
