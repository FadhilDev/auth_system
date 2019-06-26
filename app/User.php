<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    /**
     * Relation with role
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }
    /*
     * Check multiple roles
     * @param array $roles
     */
    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
        return null !== $this->roles()->whereIn('name', $roles)->first();
        }
        return $this->hasRole($roles);
    }
    /*
     * Check one role
     * @param string $role
     */
    public function hasRole($role)
    {
      return null !== $this->roles()->where('name', $role)->first();
    }
}
