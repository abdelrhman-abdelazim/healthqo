<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['body', "votes"];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function Comment()
    {
        return $this->hasMany("App\Comment");
    }

    public function User()
    {
        return $this->belongsTo("App\User");
    }

}
