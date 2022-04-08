<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            'name' => 'long124',
            'email' => 'c@gmail.com',
            'password' => bcrypt(123)
        ];
        DB::table('users')->insert($user);
    }
}
