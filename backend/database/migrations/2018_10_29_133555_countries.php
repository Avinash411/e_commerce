<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Countries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('countries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('short_country_name')->unique();
            $table->string('country_name')->unique();

            $table->integer('phonecode');
            $table->boolean('auto_approve');

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
        //
    }
}
