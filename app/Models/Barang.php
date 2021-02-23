<?php

namespace App\Models;

use App\Traits\FormatDate;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use FormatDate;

    protected $fillable = [
        'uid', 'barcode', 'nama_barang', 'harga_beli', 'harga_jual',
        'kategori_id', 'merek_id', 'stok', 'diskon'
    ];

    // relation
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function merek()
    {
        return $this->belongsTo(Merek::class);
    }
}
