<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'category_id', 'title', 'amount', 'date', 'description',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date', // Ensures the 'date' attribute is cast to a date type
    ];

    public function formattedAmount()
    {
        return number_format($this->amount, 2);
    }

    // Expense model
    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class);
    }

}
