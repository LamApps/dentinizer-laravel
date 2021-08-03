<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseQuiz extends Model
{

    use HasFactory;
    public $table='q_responses';

    public function test(){
        return $this->belongsTo(TestQuiz::class,'test_id');
    }
    public function question(){
        return $this->belongsTo(QuestionQuiz::class,'question_id');
    }
    public function answer(){
        return $this->belongsTo(answerQuiz::class,'answer_id');
    }


}
