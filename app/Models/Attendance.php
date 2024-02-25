<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'logged_in_at', // Add other fillable fields if necessary
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
