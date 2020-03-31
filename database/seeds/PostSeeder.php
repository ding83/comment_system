<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('App\Post');
        
        for($i = 1 ; $i <= 10 ; $i++){
          DB::table('posts')->insert([
            'title' => $faker->sentence(5),
            'content' => $faker->text,
            'author' => $faker->name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
          ]);
        }

    }
}
