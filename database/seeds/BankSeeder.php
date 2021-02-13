<?php

use App\Models\Bank;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $uid = ['bca', 'bni', 'bri'];
        $nama_bank = ['BCA', 'BNI', 'BRI'];

        for ($i = 0; $i < count($uid); $i++) {
            # code...
            Bank::create([
                'uid'       => $uid[$i],
                'nama_bank' => $nama_bank[$i]
            ]);
        }
    }
}
