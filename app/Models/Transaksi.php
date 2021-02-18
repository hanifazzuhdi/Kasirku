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

    public function scopeAntara($query, $tanggalAwal, $tanggalAkhir)
    {
        return $query->whereBetween('created_at', [$tanggalAwal . ' 00:00:00', $tanggalAkhir . ' 23:59:59']);
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
