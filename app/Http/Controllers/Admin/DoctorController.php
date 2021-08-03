<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Schedule;
use App\Models\Appointment;
use App\Models\DoctorQuestion;
use App\Models\DoctorProfile;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Library\Services\DbHelperTools;

use Auth;


class DoctorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    
    public function index()
    {
        // $doctors = User::all()->where('user_type', 'doctor');
        // return view('admin.users',compact('users'));

        /* $doctors = DB::table('users')
            ->leftJoin('doctors', 'users.id', '=', 'doctors.user_id')
            ->select('users.id', 'users.name', 'users.email', 'users.state', 'doctors.id AS d_id', 'doctors.birthday', 'doctors.address', 'doctors.phone', 'doctors.birthday','doctors.target')
            ->where('users.user_type', '=', 'doctor')
            ->groupBy('users.id')
            ->get(); */

            $doctors = DB::table('doctors')
            ->join('users', 'users.id', '=', 'doctors.user_id')
            ->select('doctors.*', 'users.name','users.email as doctor_email','users.state')->get();    
        
        return view('admin.doctor', compact('doctors'));
    }

    public function settarget(Request $data) 
    {
        if($data['id'] == null){
            DB::table('doctors')->insert(
                ['user_id' => $data['user_id'], 'target' => $data['target']]
            );
        } else {
            $doctor = Doctor::findOrFail($data['id']);
            $doctor->target = $data['target'];
            $doctor->save();
        }
        
        return response()->json(['success'=>'Ajax request submitted successfully']);
    }


    public function search(Request $data) 
    {
        $start_time = date('Y-M-d h:i:s', strtotime($data['start_time'])); 
        $finish_time = date('Y-M-d h:i:s', strtotime($data['finish_time'])); 
        $doctors = DB::table('users')
            ->leftJoin('doctors', 'users.id', '=', 'doctors.user_id')
            ->leftJoin('appointments', 'doctors.doctor_id', '=', 'doctors.id')
            ->select('users.id', 'users.name', 'users.email', 'users.state', 'doctors.id AS d_id', 'doctors.birthday', 'doctors.address', 'doctors.phone', 'doctors.birthday','doctors.target')
            ->where('users.user_type', '=', 'doctor')
            ->where(function ($query) {
                $query->whereDate('appointments.start_time', '>=', $start_time)
                      ->orWhereDate('appointments.finsh_time', '<=', $finish_time);
            })
            ->groupBy('users.id')
            ->get();

        return view('admin.doctor', compact('doctors'));
    }
    public function schedules()
    {
        return view('admin.schedule.index');
    }
    public function jsonDoctorsForSelect(){
        $result=[];
        $rows = DB::table('users')
            ->leftJoin('doctors', 'users.id', '=', 'doctors.user_id')
            ->select('users.id', 'users.name', 'users.email', 'users.state', 'doctors.id AS d_id', 'doctors.birthday', 'doctors.address', 'doctors.phone', 'doctors.birthday','doctors.target')
            ->where('users.user_type', '=', 'doctor')
            ->groupBy('users.id')
            ->get();
        //$rows =Doctor::select('id','user_id')->get();

        if(count($rows)>0){
            foreach($rows as $doctor){
                $result[]=['id'=>$doctor->id,'name'=>$doctor->name];
            }
        }
        return response()->json($result);
    }
    public function getSchedules($doctor_id,$day){
        $schedules = null;
        if($doctor_id>0 && $day!=''){
            $schedules = Schedule::where([['day',$day],['doctor_id',$doctor_id]])->orderBy('slot')->get();
        }
        return view('admin.schedule.list', ['schedules'=>$schedules,'doctor_id' => $doctor_id,'day'=>$day]);
    }
    public function formSlot($doctor_id,$day){
        return view('admin.schedule.form.form',['doctor_id' => $doctor_id,'day'=>$day]);
    }
    public function storeFormSlot(Request $request) {
        //dd(Carbon::createFromFormat('Y-m-d H:i','2021-04-16 09:30')->format('l'));//return 'Friday'
        //SELECT `id`,`start_hour`,`end_hour`,WEEKDAY(start_hour) FROM `af_schedules` WHERE WEEKDAY(start_hour) = 4
        //$number_day_of_week = 4;
        //$users = DB::table('af_schedules')->select('id','start_hour')->whereRaw(DB::raw('WEEKDAY(start_hour) = '.$number_day_of_week))->get();
        //lundi - MONDAY 1
        //mardi - TUESDAY 2
        //mercredi - WEDNESDAY 3
        //jeudi - THURSDAY 4
        //vendredi - FRIDAY 5
        //samedi - SATURDAY 6
        //dimanche - SUNDAY si dayOfWeekIso ->7 or si dayOfWeek ->0
        //dd(Carbon::createFromFormat('Y-m-d H:i','2021-04-19 09:30')->dayOfWeek);//1
		$success = false;
        $msg = 'Oops, something went wrong !';
        $id = 0;
        if ($request->isMethod('post')) {
            $doctor_id = $request->doctor_id;
            $day = $request->day;
            $dNow = Carbon::now();
            $started_at = Carbon::createFromFormat('Y-m-d H:i',$dNow->format('Y-m-d').' '.$request->started_at);
            $ended_at = Carbon::createFromFormat('Y-m-d H:i',$dNow->format('Y-m-d').' '.$request->ended_at);
            $DbHelperTools=new DbHelperTools();
            $dates = $DbHelperTools->generateDateRange($started_at->format('Y-m-d H:i'),$ended_at->format('Y-m-d H:i'),$request->slot_duration);
            
            if(count($dates)>0){
                $doctor_existing_time_slots = $DbHelperTools->getTimeSlotsByDoctorDay($doctor_id,$day);
                foreach($dates as $date=>$times){
                    if(count($times)){
                        foreach($times as $t){
                            if(!in_array($t,$doctor_existing_time_slots)){
                                $slot = Carbon::createFromFormat('Y-m-d H:i:s',$date.' '.$t);
                                $data = array(
                                    'id'=>$request->id,
                                    'day'=>$day,
                                    'slot'=>$slot,
                                    'doctor_id'=>$doctor_id,
                                );
                                $schedule_id=$DbHelperTools->manageSchedule($data);
                            }
                        }
                    }
                }
                $success = true;
                $msg = 'Time Slots slices have been saved successfully';
            }
        }         
        return response ()->json ( [ 
                'success' => $success,
                'msg' => $msg 
        ] );
    }
    public function deleteSchedule($id){
        /**
         * forceDelete
         */
        $success = false;
        $DbHelperTools=new DbHelperTools();
        if($id){
            $deletedRows = $DbHelperTools->massDeletes([$id],'schedule',0);
            if($deletedRows>0){
              $success = true;
            }
        }
        return response()->json(['success'=>$success]);
      }

    public function profile() {
        $doctors = DB::select("SELECT q.rate_date, q.rate, u.id, u.name FROM doctor_profiles q INNER JOIN ( SELECT max( id ) AS id FROM doctor_profiles GROUP BY user_id ) m ON q.id = m.id RIGHT JOIN users u ON q.user_id = u.id WHERE u.user_type = 'doctor'");
        
        return view('admin.doctor_profile', compact('doctors'));
    }    
    public function questions() {
        $questions = DoctorQuestion::all();    
        
        return view('admin.doctor_questions', compact('questions'));
    }
    public function question_save(Request $req) {
        if(empty($req->sel_id)){
            $question = new DoctorQuestion();
        }else{
            $question = DoctorQuestion::find($req->sel_id);
        }
        $question->question = $req->question;
        $question->save();
        return response ()->json ( [ 
                'success' => true,
                'msg' => 'Question have been saved successfully.' 
        ] );
    }
    public function question_delete(Request $req){
        DoctorQuestion::destroy($req->id);

        return response ()->json ( [ 
                'success' => true,
                'msg' => 'Question have been deleted successfully.' 
        ] );
    }
    // [{"quetion_id":1, "answer":1}, {"quetion_id":2, "answer":0}]
    public function get_rate($id) {
        $rate = DoctorProfile::where('user_id', $id)->orderBy('created_at', 'desc')->first();
        if($rate && $rate->count()>0){
            $return_data = '';
            $rate_data = json_decode($rate->rate_data);
            foreach($rate_data as $row) {
                $return_data .= '<tr>';
                $question_string = DoctorQuestion::find($row->question_id)->question;
                $return_data .= "<td>$question_string</td>";
                $return_data .= '<td><div class="d-flex justify-content-start"><div class="custom-control custom-radio mr-1"><input type="radio" name="answer_'.$row->question_id.'" id="answer_'.$row->question_id.'_yes" class="custom-control-input" value="YES"'.($row->answer=="YES"?"checked":"").'><label class="custom-control-label" for="answer_'.$row->question_id.'_yes"> YES </label></div><div class="custom-control custom-radio"><input type="radio" name="answer_'.$row->question_id.'" id="answer_'.$row->question_id.'_no" class="custom-control-input" value="NO"'.($row->answer=="NO"?"checked":"").'><label class="custom-control-label" for="answer_'.$row->question_id.'_no"> NO </label></div></div></td></tr>';
            }
            return $return_data;
        }else{
            $questions = DoctorQuestion::limit(10)->get();
            $return_data = '';
            foreach($questions as $question) {
                $return_data .= '<tr>';
                $question_string = $question->question;
                $return_data .= "<td>$question_string</td>";
                $return_data .= '<td><div class="d-flex justify-content-start"><div class="custom-control custom-radio mr-1"><input type="radio" name="answer_'.$question->id.'" id="answer_'.$question->id.'_yes" class="custom-control-input" value="YES" checked><label class="custom-control-label" for="answer_'.$question->id.'_yes"> YES </label></div><div class="custom-control custom-radio"><input type="radio" name="answer_'.$question->id.'" id="answer_'.$question->id.'_no" class="custom-control-input" value="NO"><label class="custom-control-label" for="answer_'.$question->id.'_no"> NO </label></div></div></td></tr>';
            }
            return $return_data;
        }
    }

    public function profile_save(Request $req) {
        $doctor_id = $req->sel_id;
        $rate_fetch = DoctorProfile::where('user_id', $doctor_id)->where('rate_date', now()->toDateString());
        $success = false;
        $msg = 'Oops, something went wrong !';
        $answers = array_filter($req->input(), function($k){
            return str_starts_with($k, 'answer');
        },ARRAY_FILTER_USE_KEY);
        $rate_data = array();
        $rate = 0;
        foreach($answers as $key=>$val) {
            $question_id = explode("_", $key);
            $rate_data[] = ['question_id'=>$question_id[1], "answer"=>$val];
            if($val=="YES") $rate += 10;
        }
        $profile = null;
        if($rate_fetch->count()>0) {
            $data = $rate_fetch->first();
            $current_id = $data->id;
            $profile = DoctorProfile::find($current_id);
        }else{
            $profile = new DoctorProfile();
        }
        $profile->user_id = $doctor_id;
        $profile->rate_date = now()->toDateString();
        $profile->rate_data = json_encode($rate_data);
        $profile->rate = $rate;
        $profile->save();            
        $success = true;
        $msg = 'Rated Successfully!';
        if($rate<80) {
            $prev_notif = Notification::where('to_id',$doctor_id)->where('message_type', 11)->where('is_read',0)->where('created_at', 'like', date('Y-m-d').'%')->count();
            if($prev_notif==0){
                $notif = new Notification();
                $notif->owner_id = Auth::user()->id;
                $notif->owner_type = 'App\Models\DoctorProfile';
                $notif->notification = 'Your rate is less than '.$rate.'%';
                $notif->to_id = $doctor_id;
                $notif->message_type = 11;
                $notif->save();
            }
        }

        return response ()->json ( [ 
                'success' => $success,
                'msg' => $msg 
        ] );
    }
}
