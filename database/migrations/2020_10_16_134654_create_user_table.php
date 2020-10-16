<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('mobile')->unique();
            $table->string('email')->unique();
            $table->char('user_type')->comment('1=owner,2=driver');
            $table->char('driving')->comment('1=by owner, 2=by driver');
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->integer('pin')->nullable();
            $table->integer('otp')->nullable();
            $table->string('api_token');
            $table->char('status',1)->comment('1=Active,2=Inactive')->default(1);
            $table->string('image');
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
        Schema::dropIfExists('user');
    }
}
