<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdministratorHasPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('administrator_has_permissions', function (Blueprint $table) {
        //     $table->unsignedBigInteger('administrator_id');
        //     $table->unsignedInteger('permission_id');
        //     $table->timestamps();
            
        //     $table->foreign('administrator_id')
        //         ->references('id')
        //         ->on('administrators')
        //         ->onDelete('cascade');

        //     $table->foreign('permission_id')
        //         ->references('id')
        //         ->on('permissions')
        //         ->onDelete('cascade');

        //     $table->primary(['administrator_id', 'permission_id'], 'administrator_has_permissions_primary');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('administrator_has_permissions');
    }
}
