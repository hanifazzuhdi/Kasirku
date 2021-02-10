<?php

namespace App\Models;

use App\Traits\FormatDate;
use Illuminate\Database\Eloquent\Model;

class Merek extends Model
{
    use FormatDate;

    protected $fillable = ['nama_merek'];
}
