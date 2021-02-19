<?php

namespace App\Models;

use App\Traits\FormatDate;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use FormatDate;

    protected $guarded = [];

    // relation
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}
