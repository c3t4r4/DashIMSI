<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => config('app.adminName', 'admin'),
                'email' => config('app.adminEmail', 'admin@admin.com'),
                'password' => bcrypt(config('app.adminPassword', 'Admin123')),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
