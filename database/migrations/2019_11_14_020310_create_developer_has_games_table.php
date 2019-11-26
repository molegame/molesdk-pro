<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeveloperHasGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('developer_has_games', function (Blueprint $table) {
            $table->unsignedBigInteger('developer_id');
            $table->unsignedBigInteger('game_id');
            $table->timestamps();

            $table->foreign('developer_id')
                ->references('id')
                ->on('developers')
                ->onDelete('cascade');

            $table->foreign('game_id')
                ->references('id')
                ->on('games')
                ->onDelete('cascade');

            $table->primary(['developer_id', 'game_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('developer_has_games');
    }
}
