<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cat_id')->unsigned();
            $table->integer('brand_id');
            $table->string('title');
            $table->string('ename')->nullable();
            $table->string('image_url')->nullable();
            $table->integer('inventory')->default(0);
            $table->tinyInteger('unit_id');
            $table->float('weight')->default(0);
            $table->integer('price')->nullable();
            $table->smallInteger('status')->default(0);
            $table->text('description')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('cat_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
