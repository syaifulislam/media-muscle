<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable implements JWTSubject
{
    use Notifiable;
    protected $fillable = [
        'email',
        'password',
        'profile_picture_url',
        'isPersonal',
        'isVerif',
        'name',
        'phone_code',
        'phone_number',
        'nationality',
        'date_of_birth',
        'ktp',
        'npwp',
        'address',
        'status'
    ];
    protected $hidden = [
        'password'
    ];

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [];
    }
}
