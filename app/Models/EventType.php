<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    //
    protected $table = "events_types";

    public function event ()
    {
        return $this->belongsTo('App\Models\Event','type_id', 'id');
    }
}
