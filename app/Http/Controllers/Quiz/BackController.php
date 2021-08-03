<?php

namespace App\Http\Controllers\Quiz;

use App\Models\Quiz;
use App\Models\User;

use App\Models\Doctor;
use App\Models\Category;
use App\Models\TestQuiz;
use App\Models\AnswerQuiz;
use Illuminate\Support\Arr;
use App\Models\CategoryQuiz;
use App\Models\QuestionQuiz;
use Illuminate\Http\Request;
use App\Library\Helpers\Helper;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BackController extends Controller
{
    //

    public function index($id)
    {

        return view('quiz.back.quizz',['type' =>$id ]);
    
       
    }


    public function sdtQuizs($id_quiz)
    {

        if ($id_quiz == 0) {
            $quizs = Quiz::all();
        } else {
            $quizs = Quiz::find($id_quiz);
        }

        $data=[];
        foreach ($quizs as $quiz) {
            $row = array();

            //ID:
            $row[] = $quiz->id;

            //Name:
            $row[] = $quiz->name;

            //Category:
            $row[] = $quiz->category->name . "[" . $quiz->category->code . "]";

            //Active:
            $row[] = ($quiz->is_active == 1) ? "yes" : "no";

            //Action:
                            $btn = '<div class="btn-group">
                <button type="button" onclick="_formQuiz('.$quiz->id.')" class="btn btn-icon btn-sm btn-outline-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="40px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                </svg>
                </button>
                <button class="btn btn-icon btn-sm btn-outline-primary" onclick="_deletePatient(1)" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="40px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline>
                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></button></div>';
            $row[] = $btn;

            $data[] = $row;
        }
        $result = [
            'data' => $data,
        ];
        return response()->json($result);
    }

     public function sdt_Quizs_Questions($id_Question){
        $data=array();
        if ($id_Question == 0) {
            $questions = QuestionQuiz::all();
        } else {
            $questions = QuestionQuiz::find($id_Question);
        }

        foreach ($questions as $question) {
            $row = array();

            //ID:
            $row[] = $question->id;

            //text:
            $row[] = $question->text;

            //quiz name:
            $row[] = $question->quiz->name ;

            //Active:
          //  $row[] = ($question->is_active == 1) ? "yes" : "no";

            //Action:
                        $btn = '<div class="btn-group">
            <button type="button" onclick="_formQuestions('.$question->id.')" class="btn btn-icon btn-sm btn-outline-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="40px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
            </svg>
            </button>
            <button class="btn btn-icon btn-sm btn-outline-primary" onclick="_deletePatient(1)" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="40px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline>
            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></button></div>';
                        $row[] = $btn;

            $data[] = $row;
        }
       // var_dump($data);die;
        $result = [
            'data' => $data,
        ];
        return response()->json($result);

     }

     public function sdt_Quizs_Category($id_cat){

        $data=array();
        if ($id_cat == 0) {
            $categories = CategoryQuiz::all();
        } else {
            $categories = CategoryQuiz::find($id_cat);
        }

        foreach ($categories as $category) {
            $row = array();

            //ID:
            $row[] = $category->id;

            //text:
            $row[] = $category->code;

            //quiz name:
            $row[] = $category->name ;

            //Active:
          //  $row[] = ($question->is_active == 1) ? "yes" : "no";

            //Action:
                        $btn = '<div class="btn-group">
            <button type="button" onclick="_formCategory('.$category->id.')" class="btn btn-icon btn-sm btn-outline-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="40px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
            </svg>
            </button>
            <button class="btn btn-icon btn-sm btn-outline-primary" onclick="_deletePatient(1)" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="40px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline>
            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></button></div>';
                        $row[] = $btn;

            $data[] = $row;
        }
       // var_dump($data);die;
        $result = [
            'data' => $data,
        ];
        return response()->json($result);


     }
     public function sdt_Quizs_Answer($id_answer){

        
        $data=array();
        if ($id_answer == 0) {
            $answers = AnswerQuiz::all();
        } else {
            $answers = AnswerQuiz::find($id_answer);
        }

        foreach ($answers as $answer) {
            $row = array();

            //ID:
            $row[] = $answer->id;

            //text:
            $row[] = $answer->text;

            //quiz name:
            $row[] = ($answer->is_true == 1)?'yes':'no';

            //Active:
            $row[] = $answer->question->text;

            //Action:
                 $btn = '<div class="btn-group">
            <button type="button" onclick="_formAnswer('.$answer->id.')" class="btn btn-icon btn-sm btn-outline-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="40px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
            </svg>
            </button>
            <button class="btn btn-icon btn-sm btn-outline-primary" onclick="_deletePatient(1)" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="40px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline>
            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></button></div>';
                        $row[] = $btn;

            $data[] = $row;
        }
       // var_dump($data);die;
        $result = [
            'data' => $data,
        ];
        return response()->json($result);

     }

     public function sdt_Quizs_test($id_test){

         
        $data=array();
        if ($id_test == 0) {
            $tests = TestQuiz::all();
        } else {
            $answers = TestQuiz::find($id_test);
        }

        foreach ($tests as $test) {
            $row = array();

            //ID:
            $row[] = $test->id;

            //text:
            $row[] = $test->user->name;

            //quiz name:
            $row[] = $test->quiz->name;
           
            //Active:
            $row[] = $test->nb_questions;

            $row[] = $test->user_marks;

            $row[] = $test->total_quizz_marks;
            //average
            
            $average=($test->total_quizz_marks>0)?round(($test->user_marks / $test->total_quizz_marks)*100,2):0;
            $cssClass=($average<80)?"danger":"success";
            $row[] = '<span class="text-'.$cssClass.'">'.$average.' %</span>';

            $row[] = $test->status;


            //Action:
                 $btn = '<div class="btn-group">
            <button type="button" onclick="_formTest('.$test->id.')" class="btn btn-icon btn-sm btn-outline-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="40px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
            </svg>
            </button>
            <button class="btn btn-icon btn-sm btn-outline-primary" onclick="_deletePatient(1)" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="40px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline>
            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></button></div>';
                        $row[] = $btn;

            $data[] = $row;
        }
       // var_dump($data);die;
        $result = [
            'data' => $data,
        ];
        return response()->json($result);

     }







    public function getquizform($quiz_id)
    {
        $quizz = null;
        
        if ($quiz_id > 0) {
          
            $quiz = Quiz::find($quiz_id);
            $category = CategoryQuiz::all();
           // var_dump( $quiz); die;
            return view('quiz.back.forms.quiz_form', ['quiz' => $quiz, 'category' => $category,'type'=>'quiz']);
        }

        $category = CategoryQuiz::all();

        return view('quiz.back.forms.quiz_form', ['quiz' => $quizz, 'category' => $category,'type'=>'quiz']);
    }

     public function getquestionform($question_id){

        $question = null;
        
        if ($question_id > 0) {
          
            $question = QuestionQuiz::find($question_id);
           $quizzes = Quiz::all();
            return view('quiz.back.forms.quiz_form', ['question' => $question,'quizzes'=>$quizzes,'type'=>'question']);
        }

        $quizzes = Quiz::all();

                return view('quiz.back.forms.quiz_form', ['question' => $question,'quizzes'=>$quizzes,'type'=>'question']);

      


     }

     public function getcategoryform($category_id){

        
        $categories = null;
        
        if ($category_id > 0) {
          
            $category = CategoryQuiz::find($category_id);
           //$quizzes = Quiz::all();
            return view('quiz.back.forms.quiz_form', ['category' => $category,'type'=>'category']);
        }

      //  $categories = CategoryQuiz::all();
       // var_dump($category[0]->id);

        return view('quiz.back.forms.quiz_form', ['category' => $categories,'type'=>'category']);

     }

     public function getanswerform($answer_id){

         
        $answers = null;
        
        if ($answer_id > 0) {
          
            $answer = AnswerQuiz::find($answer_id);
           $quizzes = Quiz::all();
            return view('quiz.back.forms.quiz_form', ['answer' => $answer,'type'=>'answer','quizzes'=>$quizzes]);
        }

       $quizzes = Quiz::all();
       // var_dump($category[0]->id);

        return view('quiz.back.forms.quiz_form', ['answer' => $answers,'type'=>'answer','quizzes'=>$quizzes]);

     }

     public function gettestform($test_id){

        $tests = null;
        
        if ($test_id > 0) {
          
            $test = TestQuiz::find($test_id);
           $doctors = Doctor::all();
           $quiz = Quiz::all();
            return view('quiz.back.forms.quiz_form', ['test' => $test,'type'=>'test','doctors'=>$doctors,'quizzes'=>$quiz]);
        }

      // $questions = QuestionQuiz::all();
       // var_dump($category[0]->id);
       $doctors = Doctor::all();
       $quiz = Quiz::all();
       return view('quiz.back.forms.quiz_form', ['test' => $tests,'type'=>'test','doctors'=>$doctors,'quizzes'=>$quiz]);

     }

     public function getQuestions($quiz_id){
        $result=[];
        $rows=QuestionQuiz::where('quizz_id',$quiz_id)->get();
        if(count($rows)>0){

            foreach($rows as $p){
                $result[]=['id'=>$p->id,'name'=>$p->text];
            }
        }
        return response()->json($result);
    }



    public function submitquizform(Request $request ){
           $msg="error";
           $id=0;
        if($request->id_quiz == 0 ){
            $quiz = new Quiz();
           $quiz->category_id = $request->FILTER_CATEGORY;
            $quiz->name=$request->name;
            $quiz->is_active=($request->is_active=="yes")?1:0;
            $quiz->save();
            $success=true;
            $id=$quiz->id;
            $msg = " quiz has been added successfully ";
            return response()->json([
                'success' => $success,
                'msg' => $msg,
                'id' => $id,
            ]);

        }elseif($request->id_quiz > 0  ){

           $quiz = Quiz::find($request->id_quiz) ;

            $quiz->category_id = $request->FILTER_CATEGORY;
            $quiz->name=$request->name;
            $quiz->is_active=($request->is_active=="yes")?1:0;
            $quiz->save();
            $success=true;
            $id=0;
            $msg = " quiz has been modified successfully ";
            return response()->json([
                'success' => $success,
                'msg' => $msg,
                'id' => $id,
            ]);

        }
          
        


    }

    public function submitquestionform(Request $request){

        $msg="error";
        $id=0;
     if($request->id_question == 0 ){
         $question = new QuestionQuiz();
        $question->quizz_id = $request->FILTER_QUIZ;
         $question->text=$request->text;
         $question->sort = $request->sort;
         $question->save();
         $success=true;
         $id=$question->id;
         $msg = " quiz has been added successfully ";
         return response()->json([
             'success' => $success,
             'msg' => $msg,
             'id' => $id,
         ]);

     }elseif($request->id_question > 0  ){

        $question =  QuestionQuiz::find($request->id_question);
        $question->quizz_id = $request->FILTER_QUIZ;
         $question->text=$request->text;
         $question->sort = $request->sort;
         $question->save();
         $success=true;
         $id=0;
         $msg = " quiz has been modified successfully ";
         return response()->json([
             'success' => $success,
             'msg' => $msg,
             'id' => $id,
         ]);

     }


    }
    public function submitcategoryform(Request $request){
             
        $msg="error";
        $id=0;
     if($request->id_category == 0 ){
         $category = new CategoryQuiz();
       // $question->quizz_id = $request->FILTER_QUIZ;
         $category->code=$request->code;
         $category->name = $request->name;
         $category->save();
         $success=true;
         $id=$category->id;
         $msg = " Category has been added successfully ";
         return response()->json([
             'success' => $success,
             'msg' => $msg,
             'id' => $id,
         ]);

     }elseif($request->id_category > 0  ){

        $category =  CategoryQuiz::find($request->id_category);
        $category->code=$request->code;
         $category->name = $request->name;
         $category->save();
         $success=true;
         $id=0;
         $msg = " Category has been modified successfully ";
         return response()->json([
             'success' => $success,
             'msg' => $msg,
             'id' => $id,
         ]);

     }


    }

    public function submitanswerform(Request $request){

        $msg="error";
        $id=0;
     if($request->id_answer == 0 ){
         $answer = new AnswerQuiz();
        $answer->question_id = $request->FILTER_QUESTION;
         $answer->text=$request->text;
         $answer->is_true=($request->is_true=="yes")?1:0;
         $answer->save();
         $success=true;
         $id=$answer->id;
         $msg = " Answer has been added successfully ";
         return response()->json([
             'success' => $success,
             'msg' => $msg,
             'id' => $id,
         ]);

     }elseif($request->id_answer > 0  ){

        $answer = AnswerQuiz::find($request->id_answer) ;

        $answer->question_id = $request->FILTER_QUESTION;
         $answer->text=$request->text;
         $answer->is_true=($request->is_true=="yes")?1:0;
         $answer->save();
         $success=true;
         $id=$answer->id;
         $msg = " Answer has been modified successfully ";
         return response()->json([
             'success' => $success,
             'msg' => $msg,
             'id' => $id,
         ]);

     }
    }
    public function submittestform(Request $request){

        $msg="error";
        $id=0;

     if($request->id_test == 0 ){
        
        $tests = TestQuiz::all();
        foreach($tests as $test){
            if($test->user_id  == $request->FILTER_DOCTORS){
                if($test->quizz_id == $request->FILTER_QUIZ){
                        $msg = "this test has already been signed to this doctor ";
                        $success = false;
                        return response()->json([
                            'success' => $success,
                            'msg' => $msg,
                            'id' => $id,
                        ]);
                }
            }
        }
         $test = new TestQuiz();
        $test->user_id = $request->FILTER_DOCTORS;
         $test->quizz_id=$request->FILTER_QUIZ;

       // $nb_qst = DB::select('select count(*) from q_questions where quizz_id = ?',[$request->FILTER_QUIZ]);
        
       //dd($nb_qst[0]);
       $nb_qst = QuestionQuiz::where('quizz_id',$request->FILTER_QUIZ)->count();
         $test->nb_questions=$nb_qst;
         $test->total_quizz_marks=$nb_qst;
         $test->status=$request->status;
         
         $test->save();
         $success=true;
         $id=$test->id;
         $msg = " test has been applied successfully ";
         return response()->json([
             'success' => $success,
             'msg' => $msg,
             'id' => $id,
         ]);

     }elseif($request->id_test > 0  ){

        $test = TestQuiz::find($request->id_test) ;
        $test->user_id = $request->FILTER_DOCTORS;
        $test->quizz_id=$request->FILTER_QUIZ;

      // $nb_qst = DB::select('select count(*) from q_questions where quizz_id = ?',[ $test->quizz_id]);
      $nb_qst = QuestionQuiz::where('quizz_id',$request->FILTER_QUIZ)->count();  
      $test->nb_questions=$nb_qst;
        $test->total_quizz_marks=$nb_qst;
        $test->status=$request->status;
        
        $test->save();
        $success=true;
        $id=$test->id;
         $msg = " test has been modified successfully ";
         return response()->json([
             'success' => $success,
             'msg' => $msg,
             'id' => $id,
         ]);

     }

    }
}
