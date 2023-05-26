<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            DB::table('projects')->insert([
                'owner_id' => $faker->numberBetween(4, 22),
                'name' => $faker->sentence(3),
                'description' => $faker->paragraph(),
                'status_id' => $faker->numberBetween(4, 10),
                'should_be_ended' => $faker->dateTimeBetween('now', '+1 year'),
            ]);
        }
    }
}
