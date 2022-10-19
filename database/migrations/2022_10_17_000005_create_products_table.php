<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->string('product_id');
            $table->string('name');
            $table->longText('description');
            $table->double('price');
            $table->integer('discount')->default(0);
            $table->string('shopping_store_id');
            $table->string('category_id');

            $table->primary('product_id');
            $table->foreign('shopping_store_id')->references('shopping_store_id')->on('shopping_stores');
            $table->foreign('category_id')->references('category_id')->on('categorys');

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
        Schema::dropIfExists('products');
    }
};
