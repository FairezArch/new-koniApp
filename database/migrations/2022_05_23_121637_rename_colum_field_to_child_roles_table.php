<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumFieldToChildRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('child_roles', function (Blueprint $table) {
            //
            $table->renameColumn('role_id', 'roles_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('child_roles', function (Blueprint $table) {
            //
            $table->renameColumn('roles_id', 'role_id');
        });
    }
}
