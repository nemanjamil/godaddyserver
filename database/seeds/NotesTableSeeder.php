<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Notes;

class NotesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Notes::truncate();

        $faker = Faker::create();
        $i = 0;
        while ($i < 20) {

            if ($i<7) {

                // solution 1
                Notes::create([
                    'title' => $faker->name(),
                    'user_id' => rand(1,2),
                    'textnote' => $faker->url(),
                    'typenote' => 3,
                    'active' => 1,
                    'color' => 1,
                ]);
            } elseif ($i>= 7 and $i < 14 ) {

                // solution 2
                DB::table('notes')->insert([
                    'title' => $faker->name(),
                    'user_id' => rand(1,2),
                    'textnote' => $faker->imageUrl($width = 640, $height = 480),
                    'typenote' => 2,
                    'active' => 1,
                    'color' => 1,
                ]);
            } else {

                DB::table('notes')->insert([
                    'title' => $faker->name(),
                    'user_id' => rand(1,2),
                    'textnote' => $faker->address() . ' ' . $faker->country(),
                    'typenote' => 1,
                    'active' => 1,
                    'color' => 1,
                ]);
            }

            $i++;
        }

    }
}
