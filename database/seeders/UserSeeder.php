<?php

namespace Database\Seeders;

use App\Models\User;
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
        $user = User::firstOrCreate([
            'name'              => 'supervisior',
            'national_id'       => '123456789',
            'email'             => 'super@system.com',
            'password'          => bcrypt('123456789'),
            'email_verified_at' => now() ,
            'created_at'        => now() ,
            'role_id'              => 2,
            'type'                 => 2,

        ]);

        $user = User::firstOrCreate([
            'name'              => 'supervisior2',
            'national_id'       => '123456789',
            'email'             => 'super2@system.com',
            'password'          => bcrypt('123456789'),
            'email_verified_at' => now() ,
            'created_at'        => now() ,
            'role_id'              => 2,
            'type'                 => 2,

        ]);

    }
}
