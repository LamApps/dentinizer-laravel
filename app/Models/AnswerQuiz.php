<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerQuiz extends Model
{
    use HasFactory;

    public $table = 'q_answers';


    public function question()
    {
        return $this->belongsTo(QuestionQuiz::class, 'question_id');
    }

    public function responses()
    {
        return $this->hasMany(ResponseQuiz::class);
    }


}
