<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_properties', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('tbl_users');
            $table->text('slug')->nullable();
            $table->enum('offer_type', ['Sell', 'Rent'])->nullable();
            $table->string('property_type')->nullable();
            $table->string('sub_type')->nullable();
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->integer('bedrooms')->default(0);
            $table->integer('baths')->default(0);
            $table->decimal('floor_area')->nullable();
            $table->string('floor_number')->nullable();
            $table->string('condominium_name')->nullable();
            $table->string('tower_name')->nullable();
            $table->string('car_space')->nullable();
            $table->enum('classification', ['Brand New', 'Resale', 'Foreclosed'])->nullable();
            $table->enum('fully_furnished', ['Yes', 'No', 'Semi'])->nullable();
            $table->string('sqm_range')->nullable();
            $table->integer('rooms')->nullable();
            $table->integer('total_floors')->nullable();
            $table->string('price_range')->nullable();
            $table->string('price_conditions')->nullable();
            $table->string('build_year')->nullable();
            $table->string('deposit')->nullable();
            $table->decimal('price', 15, 2);
            $table->date('available_from');
            $table->string('object_id')->nullable();
            $table->string('video_url')->nullable();
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('barangay')->nullable();
            $table->string('address')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->tinyInteger('is_featured')->default(0);
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
        Schema::dropIfExists('tbl_properties');
    }
}
