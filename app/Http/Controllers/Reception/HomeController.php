<?php

namespace App\Http\Controllers\Reception;

use Carbon\Carbon;
use App\Models\Patient;
use App\Models\Schedule;
use App\Models\Appointment;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Library\Services\DbHelperTools;

use Auth;


class HomeController extends Controller
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


        // $events = json_encode(DB::select('SELECT appointments.id, 
        //                                         CONCAT("P : ",patients.email, " -- D : ", users.email) AS title, 
        //                                         appointments.start_time AS start, 
        //                                         (appointments.start_time + INTERVAL appointments.duration MINUTE) AS end, 
        //                                         (CASE WHEN LENGTH(CONCAT("#", CONV(16712448/appointments.id, 10, 16))) = 7 THEN CONCAT("#", CONV(16712448/appointments.id, 10, 16))
        //                                                 WHEN LENGTH(CONCAT("#", CONV(16712448/appointments.id, 10, 16))) = 6 THEN CONCAT(CONCAT("#", CONV(16712448/appointments.id, 10, 16)), "0")
        //                                                 WHEN LENGTH(CONCAT("#", CONV(16712448/appointments.id, 10, 16))) = 5 THEN CONCAT(CONCAT("#", CONV(16712448/appointments.id, 10, 16)), "00")
        //                                                 WHEN LENGTH(CONCAT("#", CONV(16712448/appointments.id, 10, 16))) = 4 THEN CONCAT(CONCAT("#", CONV(16712448/appointments.id, 10, 16)), "000")
        //                                                 WHEN LENGTH(CONCAT("#", CONV(16712448/appointments.id, 10, 16))) = 3 THEN CONCAT(CONCAT("#", CONV(16712448/appointments.id, 10, 16)), "0000")
        //                                                 WHEN LENGTH(CONCAT("#", CONV(16712448/appointments.id, 10, 16))) = 2 THEN CONCAT(CONCAT("#", CONV(16712448/appointments.id, 10, 16)), "00000")
        //                                                 WHEN LENGTH(CONCAT("#", CONV(16712448/appointments.id, 10, 16))) = 1 THEN CONCAT(CONCAT("#", CONV(16712448/appointments.id, 10, 16)), "000000")
        //                                         END) AS color,
        //                                         appointments.comments AS description 
        //                                         FROM appointments
        //                                 LEFT JOIN users ON appointments.doctor_id = users.id
        //                                 LEFT JOIN patients ON patients.id = appointments.patient_id'));

        $events = collect(DB::select('SELECT appointments.id, 
                                                CONCAT(" ", users.name) AS title, 
                                                appointments.start_time AS start, 
                                                (appointments.start_time + INTERVAL appointments.duration MINUTE) AS end, 
                                                (CASE WHEN users.id % 9 = 1 THEN "new_color_1"
                                                        WHEN users.id % 9 = 2 THEN "new_color_2"
                                                        WHEN users.id % 9 = 3 THEN "new_color_3"
                                                        WHEN users.id % 9 = 4 THEN "new_color_4"
                                                        WHEN users.id % 9 = 5 THEN "new_color_5"
                                                        WHEN users.id % 9 = 6 THEN "new_color_6"
                                                        WHEN users.id % 9 = 7 THEN "new_color_7"
                                                        WHEN users.id % 9 = 8 THEN "new_color_8"
                                                        WHEN users.id % 9 = 0 THEN "new_color_9"
                                                END) AS className,
                                                appointments.comments AS description ,
                                                patients.id AS p_id,
                                                users.id AS d_id 
                                                FROM appointments
                                        LEFT JOIN users ON appointments.doctor_id = users.id
                                        LEFT JOIN patients ON patients.id = appointments.patient_id'))->unique('d_id');
        // $this->calculateMyRate();
        $doc_notifications = Notification::where(function ($query) {
                           $query->where('message_type',10)
                                 ->orWhere('message_type',12);
                       })->where(function ($query) {
                           $query->whereNull('read_users')
                                 ->orWhere('read_users', 'not like', '%'.Auth::user()->username.'%');
                       })
                       ->get();

        $pat_notifications = DB::table('reception_answers')
            ->select('reception_answers.id', 'patients.name')
            ->join('patients','reception_answers.patient_id','=','patients.id')
            ->where('reception_answers.reception_id',Auth::user()->id)
            ->where('reception_answers.answer',0)
            ->get();
        return view('reception', compact('events', 'doc_notifications','pat_notifications'));
    }

    public function getProfile($id) 
    {
        $patient_id = $id;

        $services = DB::select("SELECT patient_notes.id, patient_notes.patient_id, patient_notes.teeth_id, patient_notes.note, patient_notes.category_id, service_categories.name, services.price FROM patient_notes 
                                    LEFT JOIN service_categories on patient_notes.category_id = service_categories.id
                                    left join services on service_categories.id = services.category_id
                                    WHERE patient_notes.patient_id = ?", [$id]);
       // $services = json_encode($service);

        $data = DB::select("SELECT * FROM service_categories");
        $cat_arrs = array();
        foreach($data as $row) { 
            $cat_arrs[] = array(
                "id" => $row ->id,
                "parent" => $row -> parent_id,
                "text" => $row -> name
            );
        }
        $datas = $cat_arrs;

        return response()->json(['state'=>true, 'services'=> $services, 'datas' => $datas]);
    }

    public function getDoctorappointmentCalender(Request $request){
        $events     = collect(DB::select('SELECT appointments.id, 
                                                CONCAT(" ", patients.name, " ", patients.ar_name) AS title, 
                                                CONCAT("", patients.ar_name) AS ar_name, 
                                                CONCAT("", patients.name) AS name, 
                                                appointments.start_time AS start, 
                                                (appointments.start_time + INTERVAL appointments.duration MINUTE) AS end, 
                                                (CASE WHEN users.id % 9 = 1 THEN "new_color_1"
                                                        WHEN users.id % 9 = 2 THEN "new_color_2"
                                                        WHEN users.id % 9 = 3 THEN "new_color_3"
                                                        WHEN users.id % 9 = 4 THEN "new_color_4"
                                                        WHEN users.id % 9 = 5 THEN "new_color_5"
                                                        WHEN users.id % 9 = 6 THEN "new_color_6"
                                                        WHEN users.id % 9 = 7 THEN "new_color_7"
                                                        WHEN users.id % 9 = 8 THEN "new_color_8"
                                                        WHEN users.id % 9 = 0 THEN "new_color_9"
                                                END) AS className,
                                                appointments.comments AS description ,
                                                patients.id AS p_id,
                                                users.id AS d_id 
                                                FROM appointments
                                        LEFT JOIN users ON appointments.doctor_id = users.id
                                        LEFT JOIN patients ON patients.id = appointments.patient_id'))->whereIn('d_id',$request->doctor_id);
                                    $newData=[];
                                    if(count($events)>0){
                                        foreach($events as $e){
                                            $e->title=($e->ar_name)?$e->ar_name:$e->name;
                                            //$e->title=$e->name;
                                            //dd($e->title);
                                            if(isset($e->title) && !empty($e->title)){
                                                $newData[]=$e;
                                            }
                                        }
                                    }
                                    /* $newData[]=array(
                                        'title'=>'Event Title1',
                                        'start'=>'2021-06-13T13:13:55.008',
                                        'end'=>'2021-06-13T13:15:55.008'
                                    ); */
                                    return response()->json($newData);

    }
    public function getDoctorNearstTime($doctor_id,$start_date){
        $DbHelperTools=new DbHelperTools();
        $rs=$DbHelperTools->checkNearstAvalabilityTime($doctor_id,$start_date,0);
        return response()->json($rs);
    }
    public function getDoctorTimeSlots($doctor_id,$start_date){
        //Carbon::createFromFormat('Y-m-d H:i:s',$start_date)->dayOfWeek;
        //$number_day_of_week = $users = DB::table('doctor_schedules')->select('id','start_hour')->whereRaw(DB::raw('WEEKDAY(start_hour) = '.$number_day_of_week))->get();
        $today=Carbon::now(); 
        $tdnow=$today->format('Y-m-d'); 
        $bookedSlots = [];
        $rsBookedSlots=Appointment::select('start_time','duration')->where('doctor_id',$doctor_id)->where('start_time','LIKE','%'.$start_date.'%')->get();
        $DbHelperTools=new DbHelperTools();
        if(count($rsBookedSlots)>0){
            foreach($rsBookedSlots as $rsB){
                $dt=Carbon::createFromFormat('Y-m-d H:i:s',$rsB->start_time);
                $start_time=Carbon::createFromFormat('Y-m-d H:i:s',$rsB->start_time);
                $end_date=$start_time->addMinutes($rsB->duration);
                //dump($dt->format('Y-m-d H:i'));
                //dump($end_date->format('Y-m-d H:i'));
                $newdates=$DbHelperTools->generateDateRange($dt->format('Y-m-d H:i'),$end_date->format('Y-m-d H:i'),1);
                //dd($newdates);
                if(count($newdates)>0){
                    foreach($newdates as $data){
                        foreach($data as $hm){
                            $str=$tdnow.$hm;
                            //dd($hm);
                            $booked_dt=Carbon::createFromFormat('Y-m-d H:i:s',$str);
                            $bookedSlots[]=$booked_dt->format('H:i');
                        }
                    }
                }
                
            }
        }
        //dd($bookedSlots);
        $day = strtoupper(Carbon::createFromFormat('Y-m-d',$start_date)->format('l'));
        //dd($day);
        $slots = null;
        if($doctor_id>0 && $day!=''){
            $slots = Schedule::where([['doctor_id',$doctor_id],['day',$day]])->orderBy('slot')->get();
            $today = Carbon::now();
            if(count($slots)>0 && $today->format('Y-m-d')==$start_date){
                $newFilteredslots=[];
                foreach($slots as $s){
                    $dtslot=Carbon::createFromFormat('Y-m-d H:i:s',$s->slot);
                    $newDateToday=Carbon::createFromFormat('Y-m-d H:i:s',$dtslot->format('Y-m-d').' '.$today->format('H:i:s'));
                    //echo $dtslot->format('Y-m-d H:i:s').'---->'.$newDateToday->format('Y-m-d H:i:s').'<br>';
                    
                    if($dtslot->greaterThanOrEqualTo($newDateToday)){
                        $newFilteredslots[]=$s;
                    }
                }
                //dd($newFilteredslots);
                $slots =$newFilteredslots;
            }
        }
        return view('reception.doctor-time-slots', ['slots'=>$slots,'doctor_id' => $doctor_id,'bookedSlots'=>$bookedSlots]);
    }
    public function formAppointment($appointment_id){
        $current_time = date('Y-m-d H:i:s');
        $appointment = null;
        $patients = Patient::all();
        $doctors = DB::select("SELECT officetimes.*, users.name, users.email FROM officetimes JOIN users ON users.id = officetimes.user_id GROUP BY user_id");

        if ($appointment_id > 0) {
                $appointment = Appointment::find ( $appointment_id );
        }
        return view('reception.form.appointment',['appointment' => $appointment,'patients'=>$patients,'doctors'=>$doctors,'current_time'=>$current_time]);
    }
    public function storeFormAppointment(Request $request) {
		$success = false;
        $msg = 'Oops, something went wrong !';
        $id = 0;
        if ($request->isMethod('post')) {
            $DbHelperTools=new DbHelperTools();
            $start_time = Carbon::createFromFormat('Y-m-d H:i',$request->start_time.' '.$request->SLOT);
            $data = array(
                'id'=>$request->id,
                'appuser_id' => Auth::user()->id,
                'patient_id'=>$request->patient_id,
                'doctor_id'=>$request->doctor_id,
                'start_time'=>$start_time,
                'duration'=>$request->duration,
                'comments'=>$request->comments,
                'status'=>$request->status,
            );
            $appointment_id=$DbHelperTools->manageAppointment($data);
            $id_dp=$DbHelperTools->getDoctorPatientId($request->patient_id,$request->doctor_id);
            if($appointment_id>0 && $id_dp==0){
                $data_dp = array(
                    'id'=>$id_dp,
                    'patient_id'=>$request->patient_id,
                    'doctor_user_id'=>$request->doctor_id,
                );
                $dp_id=$DbHelperTools->manageDoctorPatient($data_dp);
            }
            $success = true;
            $msg = 'Your note have been saved successfully';
        }         
        return response ()->json ( [ 
                'success' => $success,
                'msg' => $msg 
        ] );
    }
    public function recorder(){
        return view('profile.patient.recorder');
    }
    public function storeRecorde(Request $request) {
        //dd($request->all());
        if($request->hasFile('audio_data')){
            $uploadedFile = $request->file ( 'audio_data' );
            $original_name=$uploadedFile->getClientOriginalName();
            $size=$uploadedFile->getSize();
            $path = 'uploads/files/audio/';
            $audioPath='files/audio/';
            if(!File::exists($path)) {
                File::makeDirectory($path, 0755, true, true);
            }

			$p=Storage::disk('public_uploads')->putFileAs ( $audioPath, $uploadedFile, $original_name );
			$exists = Storage::disk ( 'public_uploads' )->exists ( $audioPath."{$original_name}" );
			 if ($exists) {
				dd('success');
			}

        }
        exit();

        return response ()->json ( [ 
            'success' => true
        ] );
    }

    public function viewNotification($id) {
        $notification = Notification::find($id);
        $old_users = $notification->read_users;
        $notification->read_users = $old_users . Auth::user()->username.",";
        $notification->save();

        return redirect('reception/appointment');
    }

    public function confirmAnswer(Request $request) {
        $query = DB::table('reception_answers')->where('id',$request->id)->update(['answer'=>$request->flag]);
    }
}
