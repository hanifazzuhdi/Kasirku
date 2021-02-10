<?php

use App\Models\Member;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
            'nama'              => 'Pimpinan',
            'email'             => 'pimpinan@gmail.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('password'),
            'umur'              => 25,
            'alamat'            => 'Bantul Yogyakarta',
            'role_id'           => 1,
        ]);

        User::create([
            'nama'              => 'Staf',
            'email'             => 'staf@gmail.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('password'),
            'umur'              => 25,
            'alamat'            => 'Bantul Yogyakarta',
            'role_id'           => 2,
        ]);

        User::create([
            'nama'              => 'Kasir',
            'email'             => 'kasir@gmail.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('password'),
            'umur'              => 25,
            'alamat'            => 'Bantul Yogyakarta',
            'role_id'           => 3,
        ]);

        Member::create([
            'nomor'             => '+628999981907',
            'kode_member'       => '0008999981907',
            'nama'              => 'Member',
            'password'          => Hash::make('password'),
            'role_id'           => 4,
            'is_verified'       => 1,
            'qr_code'           => QrCode::generate('0008999981907'),
            'created_at'        => now()
        ]);
    }
}
