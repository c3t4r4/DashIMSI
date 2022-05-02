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
                'name' => config('app.ADMIN_NAME'),
                'email' => config('app.ADMIN_EMAIL'),
                'password' => bcrypt(config('app.ADMIN_PASSWORD')),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
