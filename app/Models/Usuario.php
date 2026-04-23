<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Usuario extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'nome',
        'biografia',
        'usuario',
        'senha',
        'email',
        'foto',
        'ativo'
    ];

    protected $hidden = [
        'senha',
    ];

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return[
            'login' => $this->usuario
        ];
    }

    public function getAuthPassword()
    {
        return $this->senha;
    }

}
