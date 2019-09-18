<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'title',
        'content',

        'data',
        'confirmed',
        'amount',
        'visitor',
        'options',
        'description',
        'device',
        'guid',
    ];

    public function get_fillable()
    {
        return $this->fillable;
    }

    public function subitems()
    {
        return $this->hasMany('App\SubItem');
    }
}
