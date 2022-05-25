<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
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
        // \App\Models\User::factory(10)->create();
        // User::factory(2)->create();
        $this->call([UserSeeder::class]);
        Product::factory(10)->create();
        $this->call([UserProductsSeeder::class]);

    }
}
