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
        Schema::create('shopping_stores', function (Blueprint $table) {
            $table->string('shopping_store_id');
            $table->string('user_id');
            $table->string('name')->unique();
            $table->string('phone')->unique();
            $table->string('phone2')->unique();
            $table->string('address');
            $table->string('address2');
            $table->longText('description');

            $table->primary('shopping_store_id');
            $table->foreign('user_id')->references('user_id')->on('users');
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
        Schema::dropIfExists('shoppingStores');
    }
};
