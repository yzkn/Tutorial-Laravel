<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubItem extends Model
{
    protected $table = 'subitems';

    protected $fillable = [
        'subtitle',
        'subcontent'
    ];

    public function item()
    {
        return $this->belongsTo('App\Item');
    }
}
