<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class ChildProfile extends Authenticatable implements JWTSubject
{
    protected $table      = 'child_profiles';
    protected $primaryKey = 'id';
    public    $incrementing = false;
    protected $keyType    = 'string';
    public    $timestamps = false;

    protected $fillable = ['id', 'parent_id', 'nickname', 'username', 'password_hash'];

    protected $hidden = ['password_hash'];

    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return ['role' => 'child'];
    }
}
