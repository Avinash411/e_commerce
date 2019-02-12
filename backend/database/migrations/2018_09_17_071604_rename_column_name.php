<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //this is for variant_values table to rename Value id to id for easy like we can use find and diret method so 
     Schema::table('variant__values', function (Blueprint $table) {
    $table->renameColumn('value_id', 'id');
      });
    //product variants table changine name
     Schema::table('product_variants', function (Blueprint $table) {
    $table->renameColumn('product_variant_id', 'id');
      });
     
     //product details table change name
     Schema::table('product_details', function (Blueprint $table) {
    $table->renameColumn('product_detail_id', 'id');
      });
     
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
