<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use \Illuminate\Support\Facades\Schema;
use App\User;
use App\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        DB::table('role_user')->truncate();

        $adminRole = Role::where('name', 'admin')->first();
        $secreatariaRole = Role::where('name', 'secretaria')->first();
        $tecnicoRole = Role::where('name', 'tecnico')->first();
        $medicoRole = Role::where('name', 'medico')->first();

//        $admin = User::created([
//            'name' => 'Admin User',
//            'email' => 'admin@clinica.bo',
//            'password' => Hash::make('123pedro')
//        ]);

        $admin = new User();
        $admin->name = 'Admin User';
        $admin->email = 'admin@clinica.bo';
        $admin->password = Hash::make('123pedro');
        $admin->save();

//        $secreataria = User::created([
//            'name' => 'Secreataria User',
//            'email' => 'secretaria@clinica.bo',
//            'password' => Hash::make('123pedro')
//        ]);

        $secreataria = new User();
        $secreataria->name = 'Secreataria User';
        $secreataria->email = 'secretaria@clinica.bo';
        $secreataria->password = Hash::make('123pedro');
        $secreataria->save();

//        $tecnico = User::created([
//            'name' => 'Tecnico User',
//            'email' => 'tecnico@clinica.bo',
//            'password' => Hash::make('123pedro')
//        ]);

        $tecnico = new User();
        $tecnico->name = 'Tecnico User';
        $tecnico->email = 'tecnico@clinica.bo';
        $tecnico->password = Hash::make('123pedro');
        $tecnico->save();

//        $medico = User::created([
//            'name' => 'Medico User',
//            'email' => 'medico@clinica.bo',
//            'password' => Hash::make('123pedro')
//        ]);

        $medico = new User();
        $medico->name = 'Medico User';
        $medico->email = 'medico@clinica.bo';
        $medico->password = Hash::make('123pedro');
        $medico->save();

        $admin->roles()->attach($adminRole);
        $secreataria->roles()->attach($secreatariaRole);
        $tecnico->roles()->attach($tecnicoRole);
        $medico->roles()->attach($medicoRole);

        Schema::enableForeignKeyConstraints();

    }
}
