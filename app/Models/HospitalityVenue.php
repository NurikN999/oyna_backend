<?php

namespace App\Models;

use App\Enums\HospitalityVenueType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalityVenue extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'address',
        'description',
        'city_id'
    ];

    protected $casts = [
        'type' => HospitalityVenueType::class
    ];

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
