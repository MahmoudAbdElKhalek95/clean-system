<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'first_name'  => 'Admin',
                'mid_name'  => 'Admin',
                'type'  => User::TYPE_ADMIN,
                'phone' => '123456789',
                'code' => '123456789',
                'email' => 'admin@admin.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
            ]
        );
        User::firstOrCreate(
            [
                'first_name'  => 'Client',
                'type'  => User::TYPE_CLIENT,
                'phone' => '12345678',
                'code' => '12345678',
                'email' => 'test@client.com',
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]
        );
    }
}
