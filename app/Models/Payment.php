<?php

namespace App\Models;

use App\Traits\FormatDate;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use FormatDate;

    protected $guarded = [];

    protected $hidden = [
        'updated_at', 'kode_member', 'nama_member', 'nomor_member'
    ];
}
