<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_statuses', function (Blueprint $table) {
            $table->increments('id');
            //this is id from order table which is integer like 1,2,3..
            $table->integer('reference_Order_id')->unsigned();
          //this is  order_id from order table which is string 
            $table->string('order_id');
            //this for approve,pending(its default entry when product enter) ,dispatch ,cancel(entry by user),return(entry by user)
            $table->string('status');
            //its like employee id who is going to set new status
            $table->integer('process_by');
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
        Schema::dropIfExists('order_statuses');
    }
}
