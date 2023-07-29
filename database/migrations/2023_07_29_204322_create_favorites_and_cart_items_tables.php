<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavoritesAndCartItemsTables extends Migration
{
    public function up()
    {
        // Create favorites table
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('product_id');


            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('product_id')->references('id')->on('products');


            $table->unique(['user_id', 'product_id']);

        });

        // Create cart_items table
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cart_id');
            $table->unsignedBigInteger('product_id');



            $table->foreign('cart_id')->references('id')->on('carts');
            $table->foreign('product_id')->references('id')->on('products');


            $table->unique(['cart_id', 'product_id']);

        });
    }

    public function down()
    {
        Schema::dropIfExists('favorites');
        Schema::dropIfExists('cart_items');
    }
}