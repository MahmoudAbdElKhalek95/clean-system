<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::firstOrCreate([
            'name'              => 'admin',
            'national_id'       => '123456789',
            'email'             => 'admin@system.com',
            'password'          => bcrypt('123456789'),
            'email_verified_at' => now() ,
            'created_at'        => now() ,
            'role_id'              => 1
        ]);
    }
}
