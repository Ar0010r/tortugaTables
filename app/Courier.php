<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    protected $fillable = [
        'courier_id', 'direction', 'condition', 'content', 'quantity', 'price', 'shop', 'tracking_number', 'holder'
    ];
    public function manager()
    {
        $this->belongsTo(Manager::class, 'manager_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
