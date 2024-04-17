<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointsHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount_change',
        'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
