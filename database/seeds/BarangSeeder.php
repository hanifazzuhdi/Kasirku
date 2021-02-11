<?php

use App\Models\Barang;
use Illuminate\Database\Seeder;
use Milon\Barcode\Facades\DNS1DFacade;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Barang::create([
            'uid' => "12-" . str_split(time(), 5)[1] . random_int(10, 30),
            'nama_barang' => "Indomie Goreng rasa Rendang",
            'harga_beli' => 2300,
            'harga_jual' => 2500,
            'kategori' => 1,
            'merek' => 2,
            'stok' => 10,
            'diskon' => 0,
            'barcode' => DNS1DFacade::getBarcodeSVG("12-" . str_split(time(), 5)[1] . random_int(10, 30), 'C39', 1, 33)
        ]);
    }
}
