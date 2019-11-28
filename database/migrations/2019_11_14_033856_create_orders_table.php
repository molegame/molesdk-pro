<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->uuid('player_id');
            $table->unsignedInteger('game_id');
            $table->unsignedInteger('channel_id');
            $table->string('currency');
            $table->double('amount');
            $table->string('product_id');
            $table->string('product_name');
            $table->integer('state')->default(0);
            $table->string('transaction_id')->nullable();
            $table->string('cp_order_id')->nullable();
            $table->string('callback_url')->nullable();
            $table->string('callback_info')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
