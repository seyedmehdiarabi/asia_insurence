<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products__inventory', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id')->unsigned();
            $table->integer('unit_id');
            $table->integer('healthy-old')->default(0);
            $table->integer('date-expire-old')->default(0);
            $table->integer('broken-old')->default(0);
            $table->integer('healthy-now')->default(0);
            $table->integer('date-expire-now')->default(0);
            $table->integer('broken-now')->default(0);
            $table->integer('total');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products__inventory');
    }
};
