<?php

use Illuminate\Database\Seeder;
use \App\Marker;
class MarkerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(config('clinica.marcadores') as $value){
            DB::table('markers')->insert([
                'name' => $value,
            ]);
        }

    }
}
