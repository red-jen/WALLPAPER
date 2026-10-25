<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::firstOrCreate(
            ['email' => 'admin@murart.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'status' => 'active',
                'bio' => 'MurArt Administrator',
            ]
        );

        // Designer users
        User::firstOrCreate(
            ['email' => 'designer@murart.com'],
            [
                'name' => 'Emma Designer',
                'password' => Hash::make('password'),
                'role' => 'designer',
                'status' => 'active',
                'bio' => 'Creative wallpaper designer specializing in modern geometric patterns.',
            ]
        );

        User::firstOrCreate(
            ['email' => 'designer2@murart.com'],
            [
                'name' => 'Lucas Artisan',
                'password' => Hash::make('password'),
                'role' => 'designer',
                'status' => 'active',
                'bio' => 'Nature-inspired design artist with focus on botanical themes.',
            ]
        );

        // Client/customer users
        User::firstOrCreate(
            ['email' => 'customer@murart.com'],
            [
                'name' => 'Sarah Customer',
                'password' => Hash::make('password'),
                'role' => 'client',
                'status' => 'active',
                'bio' => 'Interior design enthusiast.',
            ]
        );

        User::firstOrCreate(
            ['email' => 'customer2@murart.com'],
            [
                'name' => 'Mike Johnson',
                'password' => Hash::make('password'),
                'role' => 'client',
                'status' => 'active',
                'bio' => 'Home decorator looking for unique wallpaper designs.',
            ]
        );
    }
}
