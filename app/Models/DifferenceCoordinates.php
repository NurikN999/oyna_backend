<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DifferenceCoordinates extends Model
{
    use HasFactory;

    protected $fillable = ['difference_id', 'x1', 'y1', 'x2', 'y2'];

    public function difference()
    {
        return $this->belongsTo(Difference::class);
    }

}
