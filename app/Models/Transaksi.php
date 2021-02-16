<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $guarded = [];

    // relation
    public function kasir()
    {
        return $this->belongsTo(User::class, 'kasir_id');
    }

    public function keranjangs()
    {
        return $this->hasMany(Keranjang::class);
    }
}
