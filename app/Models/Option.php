<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'is_correct',
        'quiz_question_id',
    ];

    public function quizQuestion()
    {
        return $this->belongsTo(QuizQuestion::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function getIsCorrectAttribute($value): bool
    {
        return (bool) $value;
    }
}
