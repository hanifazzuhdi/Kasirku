<?php

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kategoris = ['Tanpa Kategori', 'Makanan', 'Minuman', 'Sabun'];

        for ($i = 0; $i < count($kategoris); $i++) {
            Kategori::create([
                'nama_kategori' => $kategoris[$i]
            ]);
        }
    }
}
