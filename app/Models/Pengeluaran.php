<?php

namespace App\Models;

use App\Traits\FormatDate;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use FormatDate;

    protected $guarded = [];

    protected $hidden = ['updated_at'];
}
