<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('type');
            $table->string('name');
            $table->string('icon');
            $table->string('key');
            $table->string('secret');
            $table->string('pub_key', 512);
            $table->string('pri_key', 1024);
            $table->string('pay_callback')->nullable();
            $table->string('pay_callback_debug')->nullable();
            $table->unsignedInteger('status')->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('games');
    }
}
