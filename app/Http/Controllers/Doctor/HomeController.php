<?php

namespace App\Http\Controllers\Doctor;

use Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Notification;
use App\Models\DoctorProfile;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\DoctorQuestion;
use Illuminate\Http\Request;
use App\Models\Doctorpatient;
use App\Library\Helpers\Helper;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Library\Services\DbHelperTools;


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
        $rsEvents = collect(DB::select('SELECT appointments.id, 
                                                patients.email AS title,
                                                patients.ar_name AS ar_name,  
                                                patients.name AS name,  
                                                appointments.start_time AS start, 
                                                (appointments.start_time + INTERVAL appointments.duration MINUTE) AS end, 
                                                appointments.comments AS description, 
                                                patients.id AS p_id, 
                                                (CASE WHEN patients.id % 9 = 1 THEN "new_color_1"
                                                        WHEN patients.id % 9 = 2 THEN "new_color_2"
                                                        WHEN patients.id % 9 = 3 THEN "new_color_3"
                                                        WHEN patients.id % 9 = 4 THEN "new_color_4"
                                                        WHEN patients.id % 9 = 5 THEN "new_color_5"
                                                        WHEN patients.id % 9 = 6 THEN "new_color_6"
                                                        WHEN patients.id % 9 = 7 THEN "new_color_7"
                                                        WHEN patients.id % 9 = 8 THEN "new_color_8"
                                                        WHEN patients.id % 9 = 0 THEN "new_color_9"
                                                END) AS className  FROM appointments
                                    LEFT JOIN users ON appointments.doctor_id = users.id
                                    LEFT JOIN patients ON patients.id = appointments.patient_id
                                    WHERE appointments.doctor_id = ?', [auth()->user()->id]));

        $newData=[];
        if(count($rsEvents)>0){
            foreach($rsEvents as $e){
                $e->title=($e->ar_name)?$e->ar_name:$e->name;
                if(isset($e->title) && !empty($e->title)){
                    $newData[]=$e;
                }
            }
        }
        $events=json_encode($newData);
        $notifications = Notification::where('to_id', Auth::user()->id)
                ->where('is_read',0)
               ->get();
        return view('doctor', compact('events', 'notifications'));
    }
    public function myPatients(){
        return view('doctor.patients');
    }
    public function sdtPatients(Request $request)
    {
        $data=$meta=$list=[];
        $doctor_user_id=(Auth::user()->user_type=='doctor')?Auth::user()->id:0;
        if($doctor_user_id>0){
            $limit=$request->limit;
            if($limit>0){
                $list=Doctorpatient::where ( 'doctor_user_id',$doctor_user_id )->limit($limit)->get();
            }else{
                $list=Doctorpatient::where ( 'doctor_user_id',$doctor_user_id )->get();
            }

            if ($request->isMethod('post')) {
                
                if ($request->has('filter_text') && !empty($request->filter_text)) {
                    $list=[];
                    $ids=Doctorpatient::select('patient_id')->where ( 'doctor_user_id',$doctor_user_id )->pluck('patient_id');
                    if(count($ids)>0){
                        $ids_patient=Patient::select('id')
                        ->whereIn('id',$ids)
                        ->where('name', 'like', '%'.$request->filter_text.'%')
                        ->orWhere('ar_name', 'like', '%'.$request->filter_text.'%')->pluck('id');

                        if(count($ids_patient)>0){
                            $list=Doctorpatient::whereIn('patient_id',$ids_patient)->where ( 'doctor_user_id',$doctor_user_id )->get();
                        }

                    } 
                }
            }

        }



        $DbHelperTools=new DbHelperTools();
        foreach ($list as $dp) {
            $row=array();
                //<th>Name</th>
                $row[]=$dp->patient->id;
                //<th>Name</th>
                $name=($dp->patient->name)?'<a href="/profile/patient/'.$dp->patient->id.'">'.$dp->patient->name.'</a>':'';
                $ar_name=($dp->patient->ar_name)?'<a href="/profile/patient/'.$dp->patient->id.'">'.$dp->patient->ar_name.'</a>':'';
                $row[]=$name.' '.$ar_name;
                //<th>Birthday</th>
                $row[]=$dp->patient->birthday;
                //<th>Address</th>
                $row[]=$dp->patient->address;
                // <th>Phone</th>
                $row[]=$dp->patient->phone;
                // <th>Status</th>
                $status='Open';
                $cssClass='success';
                if($dp->patient->state == 1){
                    $status='Complete';
                    $cssClass='warning';
                }
                $row[]='<span class="badge badge-light-'.$cssClass.'">'.$status.'</span>';
                //Appointment
                $tb=$DbHelperTools->getAppointmentsPatientDoctor($dp->patient_id,$dp->doctor_user_id);
                $info='<p class="text-info"><strong>- '.$tb['nb_appointment'].'</strong> appointment(s)</p>';
                $lastAppt=($tb['from'])?'<p class="text-primary">- Last appointment from: <strong>'.$tb['from'].'</strong> to : <strong>'.$tb['to'].'</strong></p>':'';
                $row[]=$info.$lastAppt;
                // <th>Actions</th>
                $btn_appointment='<button type="button" onclick="_formAppointment(0,'.$dp->patient->id.')" class="btn btn-sm btn-outline-primary">'.Helper::getSvgIconeByAction('NEW').' '.__('locale.book_appointment').'</button>';
                $row[]=$btn_appointment;
            $data[]=$row;
        }    
        $result = [
            'data' => $data,
        ];
        return response()->json($result);
    }
    public function formAppointment($appointment_id,$patient_id){
        $current_time = date('Y-m-d H:i:s');
        $appointment = null;
        $patients = Patient::where('id',$patient_id)->get();
        $doctor_user_id=(Auth::user()->user_type=='doctor')?Auth::user()->id:0;
        if($doctor_user_id>0){
            $doctors = User::where('user_type','doctor')->where('id','!=', $doctor_user_id)->get();
        }else{
            $ids = Doctor::select('user_id')->pluck('user_id');
            $doctors = User::whereIn('id',$ids)->get();
        }
        
        if ($appointment_id > 0) {
                $appointment = Appointment::find ( $appointment_id );
        }
        return view('doctor.form.appointment',['appointment' => $appointment,'patients'=>$patients,'doctors'=>$doctors,'doctor_user_id'=>$doctor_user_id,'current_time'=>$current_time]);
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
                'appuser_id'=>Auth::user()->id,
                'patient_id'=>$request->patient_id,
                'doctor_id'=>$request->doctor_id,
                'start_time'=>$start_time,
                'duration'=>$request->duration,
                'comments'=>$request->comments,
                'status'=>$request->status,
            );
            
            $appointment_id=$DbHelperTools->manageAppointment($data);
            $id_dp=$DbHelperTools->getDoctorPatientId($request->patient_id,$request->doctor_id);
            //dd($id_dp);
            if($appointment_id>0 && $id_dp==0){
                $data_dp = array(
                    'id'=>$id_dp,
                    'patient_id'=>$request->patient_id,
                    'doctor_user_id'=>$request->doctor_id,
                );
                $dp_id=$DbHelperTools->manageDoctorPatient($data_dp);
            }
            if(Auth::user()->user_type=="doctor"){
                if($request->status == 1) {
                    $patient_name = Patient::find($request->patient_id)->name;
                    $doctor_name = User::find($request->doctor_id)->name;
                    $notif = new Notification();
                    $notif->owner_id = Auth::user()->id;
                    $notif->owner_type = 'App\Models\Appointment';
                    $notif->notification = 'The patient '.$patient_name.' and the doctor '.$doctor_name.' are finished their appointment.';
                    $notif->to_id = $appointment_id;
                    $notif->message_type = 10;
                    $notif->save();
                }
            }
            $success = true;
            $msg = 'Your note have been saved successfully';
        }         
        return response ()->json ( [ 
                'success' => $success,
                'msg' => $msg 
        ] );
    }

    public function profile () {
        $notifications = Notification::where('to_id',Auth::user()->id)
            ->where('is_read',0)
           ->get();

        $doctors = DoctorProfile::where('user_id', Auth::user()->id)->orderBy('rate_date','desc')->get();
        return view('doctor.my_profile',compact('doctors', 'notifications'));
    }

    public function get_my_rate($id) {
        $profile = DoctorProfile::find($id);
        $rate_data = json_decode($profile->rate_data);
        $return_data = "";
        foreach($rate_data as $row) {
            $return_data .= '<tr>';
            $question_string = DoctorQuestion::find($row->question_id)->question;
            $return_data .= "<td>$question_string</td>";
            $return_data .= '<td>'.$row->answer.'</td></tr>';
        }
        return $return_data;
    }
    public function viewNotification($id) {
        $notification = Notification::find($id);
        $notification->is_read = 1;
        $notification->save();

        return redirect('doctor/profile');
    }
}
