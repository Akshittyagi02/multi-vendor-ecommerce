<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
      public function run(): void
    {
        // \App\Models\User::factory(100)->create();
        $this->call([
            RolesAndAdminSeeder::class,
            ProductSeeder::class, // Add this line to call the new product seeder
        ]);
    }
}
