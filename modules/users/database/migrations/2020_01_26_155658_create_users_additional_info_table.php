<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersAdditionalInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users__additional_info', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->string('father_name')->nullable();
            $table->integer('id_number')->nullable();
            $table->string('national_identity_number')->nullable();
            $table->string('email')->nullable();
            $table->integer('province_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('region_id')->nullable();
            $table->integer('zone_id')->nullable();
            $table->string('bank_card_number')->nullable();
            $table->string('date_of_birth',100)->nullable();
            $table->string('reagent')->nullable();
            $table->string('introduction')->nullable();
            $table->string('action')->nullable();
            $table->string('description')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users__additional_info');
    }
}
