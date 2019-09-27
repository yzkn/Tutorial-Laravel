<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubItem extends Model
{
    protected $table = 'subitems';

    protected $fillable = [
        'subtitle',
        'subcontent',
        'item_id'
    ];

    public function get_fillable()
    {
        return $this->fillable;
    }

    public function item()
    {
        return $this->belongsTo('App\Item');
    }
}
