<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideoCamerasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('video_cameras', function (Blueprint $table) {
            $table->integer('id');
            $table->string('name');
            $table->string('ip');
            $table->smallInteger('ip_decode');
            $table->string('server');
            $table->smallInteger('ip_server_decode');
            $table->smallInteger('status');
            $table->smallInteger('status_exploitation');
            $table->text('passport');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('video_cameras');
    }
}
