<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::query()->delete();
        $faker = Factory::create();

        for ($userCount = 1; $userCount <= 2; $userCount++)
        {
            $user = User::create([
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'email' => $faker->unique()->safeEmail(),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]);

            $userToken = $user->createToken('HelixToken')->plainTextToken;
            info($user->first_name . " Token ". $userToken);
        } 
    }
}
