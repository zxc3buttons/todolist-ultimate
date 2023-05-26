<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            DB::table('tasks')->insert([
                'user_id' => $faker->numberBetween(3, 22),
                'name' => $faker->sentence(3),
                'category_id' => $faker->numberBetween(1, 10),
                'description' => $faker->text(),
                'status_id' => $faker->numberBetween(1, 5),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'should_be_ended' => Carbon::now()->addDays($faker->numberBetween(1, 30)),
                'project_id' => $faker->numberBetween(5, 14)
            ]);
        }
    }
}
