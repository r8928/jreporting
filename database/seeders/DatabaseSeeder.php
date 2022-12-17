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
    public function run()
    {
        DB::table('users')->truncate();
        DB::table('users')->insert([
            'created_at' => now(),
            'firstname' => 'Admin',
            'lastname' => '',
            'username' => 'adminuser',
            'email' => 'adminuser',
            'title' => 'Administrator',
            'role' => 'admin',
            'password' => bcrypt('iamaadmin')
        ]);
        DB::table('users')->insert([
            'created_at' => now(),
            'firstname' => 'Farhan',
            'lastname' => 'Baig',
            'username' => 'farhan',
            'email' => 'farhan',
            'title' => 'Supply Chain Manger',
            'role' => 'admin',
            'password' => bcrypt('iamfarhan')
        ]);
        DB::table('users')->insert([
            'created_at' => now(),
            'firstname' => 'Supply',
            'lastname' => 'Chain',
            'username' => 'supplychain',
            'email' => 'supplychain',
            'title' => 'User',
            'role' => 'user',
            'password' => bcrypt('ssr-report')
        ]);
    }
}
