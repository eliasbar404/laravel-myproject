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
        Schema::create('transactions', function (Blueprint $table) {
            $table->string('transaction_id');
            $table->double('amount');
            $table->longText('details');
            $table->string('customer_id');
            $table->string('shopping_store_id');


            $table->primary('transaction_id');
            $table->foreign('customer_id')->references('customer_id')->on('customers');
            $table->foreign('shopping_store_id')->references('shopping_store_id')->on('shoppingStores');
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
        Schema::dropIfExists('transactions');
    }
};
