<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'isTrusted', 'rate', 'certificate', 'clinic_address',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function Section()
    {
        return $this->belongsTo("App\Section");
    }

    public function User()
    {
        return $this->belongsTo("App\User");
    }
}
