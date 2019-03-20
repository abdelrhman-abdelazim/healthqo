<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = [
        'title', 'img'
    ];


    public function Doctor()
    {
        return $this->hasMany("App\Doctor");
    }
}
