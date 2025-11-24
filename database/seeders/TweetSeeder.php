<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tweet;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TweetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        // Create some test users if they don't exist
        $users = User::all();
        if ($users->count() === 0) {
            $users = User::factory()->count(5)->create();
        }

        // Create 50 test tweets
        for ($i = 0; $i < 50; $i++) {
            Tweet::create([
                'user_id' => $users->random()->id,
                'content' => $faker->realText(rand(50, 280)),
                'created_at' => $faker->dateTimeBetween('-1 month', 'now'),
            ]);
        }
    }
}
