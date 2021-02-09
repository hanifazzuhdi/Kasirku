<?php

use App\Models\Karyawan;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nama'              => 'Admin',
            'email'             => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('password'),
            'umur'              => 25,
            'alamat'            => 'Bantul Yogyakarta',
            'role_id'           => 1
        ]);

        User::create([
            'nama'              => 'Kasir',
            'email'             => 'kasir@gmail.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('password'),
            'umur'              => 25,
            'alamat'            => 'Bantul Yogyakarta',
            'role_id'           => 2,
            'bos_id'            => 1
        ]);
    }
}
