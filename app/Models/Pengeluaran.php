<?php

namespace App\Models;

use App\Traits\FormatDate;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use FormatDate;

    protected $guarded = [];

    protected $hidden = ['updated_at'];

    // Scope
    public function scopeAntara($query, $tanggalAwal, $tanggalAkhir)
    {
        return $query->whereBetween('created_at', [$tanggalAwal . ' 00:00:00', $tanggalAkhir . ' 23:59:59']);
    }
}
