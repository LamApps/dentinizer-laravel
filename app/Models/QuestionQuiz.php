<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionQuiz extends Model
{
    use HasFactory;

    public $table = 'q_questions';

    public function quiz()
    {

        return $this->belongsTo(Quiz::class, 'quizz_id');
    }

    public function answers()
    {
        return $this->hasMany(AnswerQuiz::class);
    }

    public function responses()
    {
        return $this->hasMany(ResponseQuiz::class);
    }


}
