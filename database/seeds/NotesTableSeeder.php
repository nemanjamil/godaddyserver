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
        while ($i < 10) {

            if ($i<3) {
                DB::table('notes')->insert([
                'title' => $faker->name(),
                'textnote' => $faker->url(),
                'typenote' => 3,
                'active' => 1,
                'color' => 1,
                ]);
            } elseif ($i>= 3 and $i < 7 ) {
                DB::table('notes')->insert([
                    'title' => $faker->name(),
                    'textnote' => $faker->imageUrl($width = 640, $height = 480),
                    'typenote' => 2,
                    'active' => 1,
                    'color' => 1,
                ]);
            } else {

                DB::table('notes')->insert([
                    'title' => $faker->name(),
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
