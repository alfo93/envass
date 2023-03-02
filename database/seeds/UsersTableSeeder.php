<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('users')->insert([
            'name'          => 'Amministratore',
            'email'         => 'admin@example.com',
            'password'      => Hash::make('password'),
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s')
        ]);

        DB::table('users')->insert([
            'name'          => 'Utente',
            'email'         => 'user@example.com',
            'password'      => Hash::make('password'),
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s')
        ]);

        DB::table('role_user')->insert([
            'user_id'   => 1,
            'role_id'   => 1,
        ]);

        DB::table('role_user')->insert([
            'user_id'   => 2,
            'role_id'   => 2,
        ]);

        Model::reguard();
    }
}
