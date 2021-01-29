<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionUserTable extends Migration {
    public function up() {
        Schema::create('permission_user', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->index()
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('permission_id')
                ->index()
                ->constrained('permissions')
                ->onDelete('cascade');

            $table->timestamps();
            $table->unique(['user_id', 'permission_id']);
        });
    }

    public function down() {
        Schema::dropIfExists('permission_user');
    }
}
