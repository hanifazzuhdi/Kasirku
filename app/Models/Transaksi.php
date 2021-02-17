<?php

namespace App\Models;

use App\Traits\FormatDate;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Transaksi extends Model
{
    use FormatDate;

    protected $guarded = [];

    protected $hidden = ['updated_at'];

    // Scope
    public function ScopeTransaksiAktif()
    {
        return $this->where('kasir_id', Auth::id())->where('status', 0);
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
