<?php

namespace App\Models;

use App\Traits\FormatDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Member extends Authenticatable implements JWTSubject
{
    use FormatDate;

    protected $guard = 'member';

    protected $fillable = ['nomor', 'nama', 'password', 'kode_member', 'is_verified', 'qr_code', 'saldo'];

    protected $hidden = [
        'password', 'updated_at', 'created_at'
    ];

    // Scope
    public function ScopeMemberActive()
    {
        $this->where('is_verified', 1)->get();
    }


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
