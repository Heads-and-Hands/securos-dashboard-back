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
            $table->integer('id')->unique();
            $table->string('name');
            $table->string('ip');
            $table->tinyInteger('type');
            $table->bigInteger('ip_decode');
            $table->string('ip_server');
            $table->bigInteger('ip_server_decode');
            $table->tinyInteger('status');
            $table->tinyInteger('status_exploitation')->nullable();
            $table->text('passport')->nullable();
            $table->dateTime('approval_at')->nullable();
            $table->dateTime('creation_at')->nullable();
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
