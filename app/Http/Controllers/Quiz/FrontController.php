<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use App\Models\AnswerQuiz;
use App\Models\QuestionQuiz;
use App\Models\Quiz;
use App\Models\ResponseQuiz;
use App\Models\TestQuiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    //

    public function index()
    {
        $quizs = DB::select('SELECT t.id,q.name,t.nb_questions,t.user_marks,t.total_quizz_marks,t.status,c.name as category_name
                                    FROM q_tests t , q_quizzs q , q_categories c
                                    WHERE t.quizz_id = q.id AND
                                    q.category_id = c.id AND
                                    q.is_active = 1 AND
                                    t.user_id = ?', [auth()->user()->id]);
        return view('quiz.front.quizs', compact('quizs'));
    }

    public function formTest($test_id, $status, $cq)
    {
        $test = TestQuiz::find($test_id);
        $questions = QuestionQuiz::where('quizz_id', $test->quiz->id)->groupBy('sort')->get();
        //dd($questions);
        $question = $questions[$cq];
        //avant ndiro test wach howa deja mdawez had question

        $resultIfAlreadyAnswerQuestion = ResponseQuiz::where([['test_id', $test_id], ['question_id', $question->id]])->first();
        while ($resultIfAlreadyAnswerQuestion != null) {

            $next_question = (++$cq);
            if ($cq >= sizeof($questions)) {
                return back();
            }
            $question = $questions[$next_question];
            $resultIfAlreadyAnswerQuestion = ResponseQuiz::where([['test_id', $test_id], ['question_id', $question->id]])->first();
        };

        if (!$resultIfAlreadyAnswerQuestion) {
            $question = $questions[$cq];
        }

        $answers = AnswerQuiz::where('question_id', $question->id)->get();
        $test->status = "in_progress";
        $test->save();
        return view('quiz.front.form', compact('test', 'question', 'answers', 'cq'));
    }

    public function formTestBK($test_id, $status, $cq)
    {

        $test = TestQuiz::find($test_id);
        $questions = QuestionQuiz::where('quizz_id', $test->quiz->id)->groupBy('sort')->get();
        $question = $questions[$cq];
        $answers = AnswerQuiz::where('question_id', $question->id)->get();
        //$test->status = "in_progress";
        //$test->save();
        return view('quiz.front.form', compact('test', 'question', 'answers', 'cq'));
    }

    public function storeQuestionForm(Request $request)
    {

        $success = false;
        $msg = 'Oops, something went wrong !';
        if ($request->isMethod('post')) {

            $cq = $request->question_number;
            $cq++;

            $test = TestQuiz::find($request->test_id);


            //check if answer is correct to add score
            $answer = AnswerQuiz::find($request->answer);
            $answer_isTrue = ($answer->is_true == 1) ? true : false;
            if ($answer_isTrue) {
                $test->user_marks += $test->total_quizz_marks / $test->nb_questions;
                $test->save();
            }


            //insert history of response
            $reponse = new ResponseQuiz();
            $reponse->test_id = $request->test_id;
            $reponse->question_id = $request->question_id;
            $reponse->answer_id = $request->answer;
            $reponse->is_true = $answer->is_true;
            $reponse->save();


            $msg = '';
            //check if nb question is atteint
            if ($cq >= $test->nb_question) {
                $msg = 'The test is completed';
            }


            $quiz_mark = null;
            $quiz_total_mark = null;
            //check if quizz completed
            $nb_questions_quiz = QuestionQuiz::where('quizz_id', $request->test_id)->count();
            $nb_response_quiz = ResponseQuiz::where('test_id', $test->id)->count();
            if ($nb_questions_quiz == $nb_response_quiz) {
                $test->status = "finished";
                $test->save();
                $msg = __('locale.quiz.mark');
                $quiz_mark = $test->user_marks;
                $quiz_total_mark = $test->total_quizz_marks;
            }

            $success = true;

        }
        return response()->json([
            'success' => $success,
            'msg' => $msg,
            'test_id' => $test->id,
            'cq' => $cq,
            'quiz_mark' => $quiz_mark,
            'quiz_total_mark' => $quiz_total_mark,
        ]);
    }

}
