<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

     
        Schema::create('shoppings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('credit_card_id');
            $table->foreign('credit_card_id')->references('id')->on('credit_cards');
            $table->unsignedBigInteger('category_shopping_id');
            $table->foreign('category_shopping_id')->references('id')->on('shopping_categories');
            $table->datetime('purchase_date');
            $table->float('amount',10,2);
            $table->integer('installment')->default(1);
            $table->boolean('payed')->default(false);
            $table->string('description')->nullable();
            $table->string('name');
            $table->float('fees')->default(0);
            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shoppings');
    }
};
