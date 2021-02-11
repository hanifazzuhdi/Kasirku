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
            'is_verified'       => 1
        ]);

        User::create([
            'nama'              => 'Mujahid',
            'email'             => 'staf@gmail.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('password'),
            'umur'              => 25,
            'alamat'            => 'Bantul Yogyakarta',
            'role_id'           => 2,
            'is_verified'       => 1
        ]);

        User::create([
            'nama'              => 'Ihsan',
            'email'             => 'kasir@gmail.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('password'),
            'umur'              => 25,
            'alamat'            => 'Bantul Yogyakarta',
            'role_id'           => 3,
            'is_verified'       => 1
        ]);

        Member::create([
            'nomor'             => '+628999981907',
            'kode_member'       => '0008999981907',
            'nama'              => 'Usman Among Us',
            'password'          => Hash::make('password'),
            'role_id'           => 4,
            'is_verified'       => 1,
            'qr_code'           => 'https://res.cloudinary.com/hanif-it/image/upload/v1613016652/kip3hduknuulkidlqpwi.png',
            'created_at'        => now()
        ]);

        Member::create([
            'nomor'             => '+6285210593721',
            'kode_member'       => '0005210593721',
            'nama'              => 'Zen',
            'password'          => Hash::make('password'),
            'role_id'           => 4,
            'is_verified'       => 1,
            'qr_code'           => 'https://res.cloudinary.com/hanif-it/image/upload/v1613027643/msconyaleyz8txfbflsg.png',
            'created_at'        => now()
        ]);
    }
}
