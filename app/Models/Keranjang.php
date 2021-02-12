<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $guarded = [];

    // relation
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}
