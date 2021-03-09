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
            $table->tinyInteger('type');
            $table->bigInteger('ip_decode');
            $table->string('ip_server');
            $table->bigInteger('ip_server_decode');
            $table->tinyInteger('status');
            $table->tinyInteger('status_exploitation');
            $table->text('passport')->nullable();
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
