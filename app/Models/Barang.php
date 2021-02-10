<?php

namespace App\Models;

use App\Traits\FormatDate;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use FormatDate;

    protected $fillable = [
        'uid', 'barcode', 'nama_barang', 'harga_beli', 'harga_jual',
        'kategori', 'merek', 'stok', 'diskon'
    ];

    protected $hidden = [
        //
    ];
}
