<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'paid',
        'order_id',
        'user_id',
        'payment_method_id'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    

}
