<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();
        \App\Models\User::factory()->create([
            'email' => 'admin@dev.com',
            'password' => 'password',
            'name' => 'Admin'
        ]);

        \App\Models\User::factory()->create([
            'email' => 'editor@dev.com',
            'password' => 'password',
            'name' => 'Editor'
        ]);

        $this->call([
            RolesSeeder::class,
            CategoriesSeeder::class,
            ProductsSeeder::class,
        ]);
    }
}
