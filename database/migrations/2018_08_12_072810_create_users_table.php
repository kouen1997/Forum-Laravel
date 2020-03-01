<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->string('password');

            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->date('birth_date')->nullable();

            $table->integer('sponsor_id')->nullable()->unsigned();
            $table->foreign('sponsor_id')->references('id')->on('tbl_users');

            $table->string('sponsor_username')->nullable();

            $table->tinyInteger('role')->default(1);
            $table->boolean('active')->default(0);   
            $table->boolean('retailer')->default(0);
            $table->integer('retailer_user_id')->nullable(); 
            $table->string('pin', 10)->nullable();
            $table->integer('pin_attempt')->default(0);
            $table->integer('social_id')->nullable();
            $table->integer('emall_id')->nullable();

           
            $table->dateTime('last_login_at')->nullable();
            $table->date('activated_at')->nullable();


            $table->rememberToken();
            $table->timestamps();

            $table->index(['username', 'email', 'role', 'sponsor_username', 'sponsor_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_users');
    }
}
