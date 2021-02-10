<?php

namespace App\Models;

use App\Traits\FormatDate;
use Illuminate\Database\Eloquent\Model;


class Supplier extends Model
{
    use FormatDate;

    protected $fillable = [
        'nama_supplier'
    ];
}