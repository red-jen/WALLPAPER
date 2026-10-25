<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            PaperSeeder::class,
            DesignSeeder::class,
            WallpaperSeeder::class,
        ]);

        $this->command->info('Database seeded successfully!');
        $this->command->info('');
        $this->command->info('Demo Credentials:');
        $this->command->info('  Admin: admin@murart.com / password');
        $this->command->info('  Designer: designer@murart.com / password');
        $this->command->info('  Customer: customer@murart.com / password');
    }
}
