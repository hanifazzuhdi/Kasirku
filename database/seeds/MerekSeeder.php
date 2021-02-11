<?php

use App\Models\Merek;
use Illuminate\Database\Seeder;

class MerekSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mereks = ['Detol', 'Indomie', 'Indomilk'];

        for ($i = 0; $i < count($mereks); $i++) {
            Merek::create([
                'nama_merek' => $mereks[$i]
            ]);
        }
    }
}
