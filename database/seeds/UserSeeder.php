<?php

use Illuminate\Database\Seeder;
use \App\Models\User;
use \App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'first_name'    => 'Tamara',
            'last_name'     => 'Vasiljevic',
            'email'         => 'admin@admin.com',
            'password'      => Hash::make('admin123'),
            'phone'         => '+38765893940',
            'timezone'      => 'UTC'
        ]);

        $adminRole = Role::where('name', '=', Role::ROLE_ADMINISTRATOR)->get()->first();

        $user->roles()->attach($adminRole->id);
    }
}
