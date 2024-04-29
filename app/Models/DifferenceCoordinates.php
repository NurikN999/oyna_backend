<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DifferenceCoordinates extends Model
{
    use HasFactory;

    protected $fillable = ['difference_id', 'x', 'y'];

    public function difference()
    {
        return $this->belongsTo(Difference::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

}
