<?php

use App\Models\Barang;
use App\Providers\UploadProvider;
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
            'uid' => "12-19070101",
            'nama_barang' => "Indomie Goreng rasa Rendang",
            'harga_beli' => 2300,
            'harga_jual' => 2500,
            'kategori' => 1,
            'merek' => 2,
            'stok' => 10,
            'diskon' => 0,
            'barcode' => 'https://res.cloudinary.com/hanif-it/image/upload/v1613016682/wsrf49t93dly62lf3zri.png'
        ]);
    }
}
