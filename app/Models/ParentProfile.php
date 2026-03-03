<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class ParentProfile extends Authenticatable implements JWTSubject
{
    protected $table      = 'parent_profiles';
    protected $primaryKey = 'id';
    public    $incrementing = false;
    protected $keyType    = 'string';
    public    $timestamps = false;

    protected $fillable = ['id', 'name', 'email', 'password_hash'];

    protected $hidden = ['password_hash'];

    // Necessário para o JWT
    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return ['role' => 'parent'];
    }
}
