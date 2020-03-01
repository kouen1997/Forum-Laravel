<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_members', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('tbl_users');

            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->date('birth_date')->nullable();

            $table->integer('sponsor_id')->nullable()->unsigned();
            $table->foreign('sponsor_id')->references('id')->on('tbl_users');

            $table->string('sponsor_username')->nullable();
            $table->boolean('active')->default(0);
            $table->dateTime('last_login_at')->nullable();
            $table->date('activated_at')->nullable();
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
        Schema::dropIfExists('tbl_members');
    }
}
