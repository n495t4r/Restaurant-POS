<?php

// app/Models/KitchenOrder.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KitchenOrder extends Model
{
    protected $fillable = [
        'order_id',
        'details',
        'is_done',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
