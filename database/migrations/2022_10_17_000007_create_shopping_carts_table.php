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
        Schema::create('shoppingCarts', function (Blueprint $table) {
            $table->string('shopping_cart_id');
            $table->string('cart_id');
            $table->string('product_id');
            $table->integer('quantity');

            $table->primary('shopping_cart_id');
            $table->foreign('cart_id')->references('cart_id')->on('carts');
            $table->foreign('product_id')->references('product_id')->on('products');
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
        Schema::dropIfExists('shoppingCarts');
    }
};
