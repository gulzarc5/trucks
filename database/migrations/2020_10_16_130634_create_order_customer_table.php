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
            $table->string('customer_id')->nullable();
            $table->bigInteger('truck_type_id')->nullable();
            $table->string('material')->nullable();
            $table->bigInteger('source_city_id')->nullable();
            $table->bigInteger('destination_city_id')->nullable();
            $table->bigInteger('weight_id')->nullable();
            $table->integer('no_of_trucks')->nullable();
            $table->date('schedule_date')->nullable();
            $table->char('bid_status',1)->default(1)->comment('1 = new, 2=Open,3=Ended');
            $table->double('amount',10,2)->default(0);
            $table->double('advance_amount',10,2)->default(0);
            $table->char('payment_type',1)->default(1)->comment('1 = offline payment, 2 = online payment');
            $table->char('payment_status',1)->default(1)->comment('1 = fail, 2 = paid');
            $table->string('payment_request_id',256)->nullable();
            $table->string('payment_id',256)->nullable();
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
