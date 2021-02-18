<?php

namespace App\Models;

use App\Traits\FormatDate;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use FormatDate;

    protected $fillable = [
        'supplier_id', 'barang', 'total_barang', 'harga_satuan', 'total_harga', 'status'
    ];

    // Scope
    public function scopeAntara($query, $tanggalAwal, $tanggalAkhir)
    {
        return $query->whereBetween('created_at', [$tanggalAwal . ' 00:00:00', $tanggalAkhir . ' 23:59:59']);
    }

    // Relation
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
