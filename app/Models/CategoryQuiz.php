<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryQuiz extends Model
{
    use HasFactory;

    public $table = 'q_categories';

    public function quizs()
    {
        return $this->hasMany(Quiz::class);
    }
}
