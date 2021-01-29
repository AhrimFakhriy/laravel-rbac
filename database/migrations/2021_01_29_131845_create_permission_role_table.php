<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionRoleTable extends Migration {
    public function up() {
        Schema::create('permission_role', function (Blueprint $table) {
            $table->foreignId('role_id')
                ->index()
                ->constrained('roles')
                ->onDelete('cascade');

            $table->foreignId('permission_id')
                ->index()
                ->constrained('permissions')
                ->onDelete('cascade');

            $table->timestamps();
            $table->unique(['role_id', 'permission_id']);
        });
    }

    public function down() {
        Schema::dropIfExists('permission_role');
    }
}
