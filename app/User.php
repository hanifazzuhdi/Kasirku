<?php

namespace App;

use App\Models\Transaksi;
use App\Traits\FormatDate;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements MustVerifyEmail, JWTSubject
{
    use Notifiable, FormatDate;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
        'umur',
        'alamat',
        'avatar',
        'remember_token',
        'role_id',
        'is_verified',
        'updated_at', 'created_at', 'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getEmailVerifiedAtAttribute()
    {
        return Carbon::parse($this->attributes['email_verified_at'])->translatedFormat('d, F Y H:i');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    // Relation
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'kasir_id');
    }
}
