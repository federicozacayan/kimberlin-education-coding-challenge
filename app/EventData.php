<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventData extends Model
{
    protected $fillable = ['title','description', "image", "type", "paid"];

    function dates(){
        return $this->hasMany('App\EventDate');
    }
}
