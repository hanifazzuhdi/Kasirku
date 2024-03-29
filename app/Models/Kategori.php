<?php

namespace App\Models;

use App\Traits\FormatDate;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use FormatDate;

    protected $fillable = ['nama_kategori'];

    // relation
    public function barang()
    {
        return $this->hasMany(Barang::class);
    }
}
