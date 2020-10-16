<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_customer', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('customer_id');
            $table->char('truck_type')->comment('1=container, 2=truck 20MT/12 Wheeel');
            $table->string('material');
            $table->string('source');
            $table->string('destination');
            $table->integer('weight');
            $table->integer('No of Trucks');
            $table->date('schedule_date');
            $table->char('bid_status')->comment('1=Open,2=Ended');
            $table->string('truck_id_assigned');
            $table->string('driver_id_assigned');
            $table->date('assigned_date');
            $table->char('assign_status');
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
        Schema::dropIfExists('order_customer');
    }
}
