<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'amount',
        'order_id',
        'user_id',
        'payment_methods'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    

}
