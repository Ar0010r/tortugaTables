<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function courier()
    {
        $this->belongsTo(Courier::class, 'courier_id', 'id');
    }
}
