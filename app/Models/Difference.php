<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Difference extends Model
{
    use HasFactory;

    protected $fillable = ['game_level', 'game_id'];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function coordinates()
    {
        return $this->hasMany(DifferenceCoordinates::class);
    }
}
