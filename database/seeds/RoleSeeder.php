<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'role_name' => 'pimpinan'
        ]);

        Role::create([
            'role_name' => 'staf'
        ]);

        Role::create([
            'role_name' => 'kasir'
        ]);

        Role::create([
            'role_name' => 'member'
        ]);
    }
}
