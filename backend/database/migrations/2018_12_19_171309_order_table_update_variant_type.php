<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrderTableUpdateVariantType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->text('product_variant_id')->change();
            $table->renameColumn('product_variant_id', 'ordered_combination');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
           
            $table->integer('ordered_combination')->unsigned()->change();
            $table->renameColumn('ordered_combination','product_variant_id');
        });
    }
}
