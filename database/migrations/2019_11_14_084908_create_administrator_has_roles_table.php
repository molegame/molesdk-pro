<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdministratorHasRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('administrator_has_roles', function (Blueprint $table) {
        //     $table->unsignedBigInteger('administrator_id');
        //     $table->unsignedInteger('role_id');
        //     $table->timestamps();
            
        //     $table->foreign('administrator_id')
        //         ->references('id')
        //         ->on('administrators')
        //         ->onDelete('cascade');

        //     $table->foreign('role_id')
        //         ->references('id')
        //         ->on('roles')
        //         ->onDelete('cascade');

        //     $table->primary(['administrator_id', 'role_id']);
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('administrator_has_roles');
    }
}
