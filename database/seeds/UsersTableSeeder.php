<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

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
        User::truncate();
        DB::table('role_user')->truncate();

        $adminRole = Role::where('name', 'admin')->first();
        $secreatariaRole = Role::where('name', 'secretaria')->first();
        $tecnicoRole = Role::where('name', 'tecnico')->first();
        $medicoRole = Role::where('name', 'medico')->first();

        $admin = User::created([
            'name' => 'Admin User',
            'email' => 'admin@clinica.bo',
            'password' => Hash::make('123pedro')
        ]);

        $secreataria = User::created([
            'name' => 'Secreataria User',
            'email' => 'secretaria@clinica.bo',
            'password' => Hash::make('123pedro')
        ]);

        $tecnico = User::created([
            'name' => 'Tecnico User',
            'email' => 'tecnico@clinica.bo',
            'password' => Hash::make('123pedro')
        ]);

        $medico = User::created([
            'name' => 'Medico User',
            'email' => 'medico@clinica.bo',
            'password' => Hash::make('123pedro')
        ]);

        $admin->roles()->attach($adminRole);
        $secreataria->roles()->attach($secreatariaRole);
        $tecnico->roles()->attach($tecnicoRole);
        $medico->roles()->attach($medicoRole);

    }
}
