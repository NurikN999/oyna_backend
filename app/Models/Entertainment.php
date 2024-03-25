<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entertainment extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'address',
        'description',
        'city_id',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
