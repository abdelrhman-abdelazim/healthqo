<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'address', 'state', 'country', 'gender', 'phone', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function Post()
    {
        return $this->hasMany("App\Post");
    }

    public function Comment()
    {
        return $this->hasMany("App\Comment");
    }
    public function Doctor()
    {
        return $this->hasOne("App\Doctor");
    }

}
