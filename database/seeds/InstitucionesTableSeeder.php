<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class InstitucionesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for($i=0; $i < 15; $i++){
            \Illuminate\Support\Facades\DB::table('instituciones')->insert(array(
                'nombre' => $faker->firstName,
            ));
        }
    }
}
