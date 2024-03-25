<?php

namespace App\Models;

use App\Enums\MusicGenreType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'title',
        'genre',
    ];

    protected $casts = [
        'genre' => MusicGenreType::class
    ];

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
