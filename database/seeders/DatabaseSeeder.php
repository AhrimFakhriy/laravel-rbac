<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        DB::table('users')->insert([
            'name' => 'test-user',
            'email' => 'test@example.com',
            'password' => bcrypt('password')
        ]);

        DB::table('permissions')->insert([
            [
                'name' => 'permission-1',
                'slug' => 'permission-1',
            ], [
                'name' => 'permission-2',
                'slug' => 'permission-2',
            ], [
                'name' => 'permission-through-role',
                'slug' => 'permission-through-role',
            ]
        ]);

        DB::table('roles')->insert([
            [
                'name' => 'role-1',
                'slug' => 'role-1',
            ], [
                'name' => 'role-2',
                'slug' => 'role-2'
            ]
        ]);

        DB::table('permission_user')->insert([
            'user_id' => 1,
            'permission_id' => 1
        ]);

        DB::table('role_user')->insert([
            'user_id' => 1,
            'role_id' => 1,
        ]);

        DB::table('permission_role')->insert([
            'role_id' => 1,
            'permission_id' => 3
        ]);
    }
}
