<?php

namespace App\Models;

use App\Traits\FormatDate;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use FormatDate;

    protected $guarded = [];
}
