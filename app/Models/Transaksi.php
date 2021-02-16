<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Transaksi extends Model
{
    protected $guarded = [];

    // Scope
    public function ScopeTransaksiAktif()
    {
        return $this->where('kasir_id', Auth::id())->where('status', 0)->firstOrFail();
    }

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
