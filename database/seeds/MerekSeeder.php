<?php

use App\Models\Merek;
use App\Models\Supplier;
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
        Supplier::create([
            'nama_supplier' => 'PT.Indomie Indonesia'
        ]);

        $mereks = ['Tanpa Merek', 'Detol', 'Indomie', 'Indomilk'];

        for ($i = 0; $i < count($mereks); $i++) {
            Merek::create([
                'nama_merek' => $mereks[$i]
            ]);
        }
    }
}
