<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestQuiz extends Model
{
    use HasFactory;

    public $table = 'q_tests';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quizz_id');
    }

    public function responses()
    {
        return $this->hasMany(ResponseQuiz::class);
    }
}
