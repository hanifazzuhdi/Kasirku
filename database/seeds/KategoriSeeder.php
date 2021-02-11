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
        $kategoris = ['Makanan', 'Minuman', 'Sabun'];

        for ($i = 0; $i < count($kategoris); $i++) {
            Kategori::create([
                'nama_kategori' => $kategoris[$i]
            ]);
        }
    }
}
