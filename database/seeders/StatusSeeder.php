<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 10; $i++) {
            DB::table('statuses')->insert([
                'name' => $faker->word(),
                'description' => $faker->sentence(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
