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
                'name' => config('app.admin_name', 'admin'),
                'email' => config('app.admin_email', 'admin@admin.com'),
                'password' => bcrypt(config('app.admin_password', 'Admin123')),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
