<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQResponses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('q_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_id')->constrained('q_tests');
            $table->foreignId('question_id')->constrained('q_questions');
            $table->foreignId('answer_id')->constrained('q_answers');
            $table->integer('is_true');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('q_responses');
    }
}
