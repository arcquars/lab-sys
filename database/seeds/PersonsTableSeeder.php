<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PersonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for($i=0; $i < 10; $i++){
            \Illuminate\Support\Facades\DB::table('persons')->insert(array(
                'ci' => $faker->unique()->numberBetween(58555, 988888),
                'nombres' => $faker->firstName,
                'apellidos' => $faker->lastName,
                'f_nacimiento' => $faker->dateTimeBetween('-50 years')
            ));
        }
    }
}
