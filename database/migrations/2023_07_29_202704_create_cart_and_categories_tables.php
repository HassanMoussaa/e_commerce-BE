<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartAndCategoriesTables extends Migration
{
    public function up()
    {
        // Create 'cart' table
        Schema::create('cart', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id'); // Foreign key column



            $table->foreign('user_id')->references('id')->on('users');
        });

        // Create 'categories' table
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');

        });
    }

    public function down()
    {
        Schema::dropIfExists('categories');
        Schema::dropIfExists('cart');
    }
}