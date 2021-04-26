<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApprovedAndUpdateTimeToVideoCamerasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('video_cameras', function (Blueprint $table) {
            $table->boolean('approved')->default(false);
            $table->dateTime('update_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('video_cameras', function (Blueprint $table) {
            $table->dropColumn('approved', 'update_time');
        });
    }
}
