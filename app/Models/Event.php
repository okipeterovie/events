<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //

    protected $table ="events";

    public function type ()
    {
        return $this->hasOne('App\Models\EventType', 'id');
    }
}
