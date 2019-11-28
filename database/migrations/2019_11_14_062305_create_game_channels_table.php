<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_channels', function (Blueprint $table) {
            $table->unsignedBigInteger('game_id');
            $table->unsignedBigInteger('channel_id');
            $table->string('bundle_id')->nullable();
            $table->string('icon')->nullable();
            $table->string('splashes', 2048)->nullable();
            $table->string('goods', 4096)->nullable();
            $table->string('params', 4096)->nullable();
            $table->timestamps();
            
            $table->foreign('game_id')
                ->references('id')
                ->on('games')
                ->onDelete('cascade');

            $table->primary(['game_id', 'channel_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_channels');
    }
}
