<?php

namespace App\Models;

use App\Traits\FormatDate;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use FormatDate;

    protected $fillable = [
        'supplier_id', 'barang', 'total_barang', 'total_harga'
    ];
}
