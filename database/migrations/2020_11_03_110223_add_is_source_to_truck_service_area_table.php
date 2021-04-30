<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsSourceToTruckServiceAreaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('truck_service_area', function (Blueprint $table) {
            $table->char('is_source',1)->default(1)->comment('1=No, 2 = Yes')->after('service_area');
            $table->char('status',1)->default(1)->comment('1=Enable, 2 = Disable')->after('is_source');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('truck_service_area', function (Blueprint $table) {
            //
        });
    }
}
