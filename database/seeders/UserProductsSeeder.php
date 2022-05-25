<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use App\Models\UserProduct;
use Illuminate\Database\Seeder;

class UserProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        UserProduct::query()->delete();
        $products = Product::get()->pluck('id')->shuffle();
        $products = $products->chunk($products->count() / 2);
        $users = User::get()->pluck('id');

        collect($users)->each(function ($user_id, $key) use ($products)
        {
            foreach ($products[$key] as $product_id) 
            {
                UserProduct::create([
                    'user_id' => $user_id,
                    'product_id' => $product_id
                ]);
            }
        });

    }
}
