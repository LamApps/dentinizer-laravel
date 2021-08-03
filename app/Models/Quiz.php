<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\This;

class Quiz extends Model
{
    use HasFactory;

    public $table = 'q_quizzs';


    public function category()
    {

        return $this->belongsTo(CategoryQuiz::Class, 'category_id');
    }

    public function questions()
    {
        return $this->hasMany(QuestionQuiz::class);
    }

    public function tests()
    {
        return $this->hasMany(TestQuiz::class);
    }
}
