<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'game_id',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
