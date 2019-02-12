<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuantityOfProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quantity_of_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quantity')->default('0');
            $table->integer('order_id')->default('0');
            $table->integer('product_id');
            $table->integer('product_variant_id');
             $table->softDeletes();
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
        Schema::dropIfExists('quantity_of_products');
    }
}
