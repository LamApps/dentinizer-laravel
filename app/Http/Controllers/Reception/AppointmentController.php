<?php

namespace App\Http\Controllers\Reception;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Service;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Notification;
use DateTime;
use Auth;

class AppointmentController extends Controller
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
        $c_dayofweek = date('w', strtotime(date('Y-m-d')));
        $c_hour = date("H");
        $current_time = date('Y-m-d H:i:s');

        //$patients = Patient::all();
        //$services = Service::all();
        /* $doctors = DB::select("SELECT officetimes.*, users.name, users.email FROM officetimes
                                    LEFT JOIN users ON users.id = officetimes.user_id
                                    GROUP BY user_id"); */

        /* $appointments = json_encode(DB::select("SELECT appointments.*, users.email as d_email, patients.email as p_email 
                                                    FROM appointments
                                                    LEFT JOIN users ON users.id = appointments.doctor_id
                                                    LEFT JOIN patients ON patients.id = appointments.patient_id ORDER by appointments.id desc")); */
        
        //return view('reception.appointment',compact('appointments', 'patients', 'doctors', 'current_time' ));
        //$appointments =Appointment::all();
        $appointments = DB::table('appointments')
            ->join('users', 'users.id', '=', 'appointments.doctor_id')
            ->join('patients', 'patients.id', '=', 'appointments.patient_id')
            ->select('appointments.*', 'users.name as doctor_name','users.email as doctor_email','patients.ar_name','patients.name')
            ->get();
        $doc_notifications = Notification::where('message_type',10)
                        ->where(function ($query) {
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
          //dd($appointments);  
        return view('reception.appointment',compact('appointments', 'doc_notifications', 'pat_notifications'));
    }



    public function store(Request $data) 
    {
        Appointment::updateOrCreate(
            [
                'id' => $data['id']
            ],
            [
            'appuser_id' => Auth::user()->id,
            'patient_id' => $data['patient_id'],
            'doctor_id' => $data['doctor_id'],
            'start_time' => $data['start_time'],
            'duration' => $data['duration'],
            'status' => $data['status'],
            'comments' => $data['comments'],
        ]);
        return response()->json(['success'=>'Ajax request submitted successfully']);
    }


    public function getTimes($doctor, $duration, $starttime, $endtime, $current_time) {

        $return_value = array("state" => false, "start_time" => "0");

        $appointments = DB::select("SELECT start_time, (start_time + INTERVAL duration MINUTE) as endtime FROM appointments
                            WHERE doctor_id = ?
                                AND start_time >= ?
                                AND (start_time + INTERVAL duration MINUTE) <= ?", [ $doctor, $starttime, $endtime]);

        if ( count($appointments) >= 1 ) {
            $max_date = $appointments[0]->endtime;
            foreach($appointments as $appointment){
                $temp_date = $appointment->endtime;
                if ($temp_date >= $max_date)
                    $max_date = $temp_date;
            }

            $dteStart = new DateTime($max_date);
            $dteEnd   = new DateTime($endtime);
            $dteDiff  = $dteStart->diff($dteEnd);
            $hour =  $dteDiff->format("%H");
            $min =  $dteDiff->format("%I");
            $total = $hour * 60 + $min;

            if($total >= $duration)
                $return_value = array("state" => true, "start_time" => $max_date);

        } else if ( count($appointments) == 0 ) {
            $return_value = array("state" => true, "start_time" => $starttime);
        }
        return $return_value;

    }


    public function checkstate($duration, $doctor, $starttime, $endtime) 
    {

        $current_time = date('Y-m-d H:i:s');
        $current_day = date('Y-m-d');
        $c_dayofweek = date('w', strtotime(date('Y-m-d')));
        
        $s_time = "";
        $e_time = "";
        $available_days = DB::select("SELECT * FROM officetimes WHERE user_id = ? ORDER BY day ASC", [ $doctor]);

        $new_arr = array();
        $small_new_arr = array();
        foreach($available_days as $temp) {
            if ($temp->day>=$c_dayofweek) {
                array_push($new_arr, $temp);
            }else{
                array_push($small_new_arr, $temp);
            }
        }

        foreach($small_new_arr as $temp) {
            array_push($new_arr, $temp);
        }
       // var_dump($new_arr);
        foreach($new_arr as $available_day) {
           
            if ( $c_dayofweek ==  $available_day->day) {
                $flag = $this->getTimes($doctor, $duration, $starttime, $endtime, $current_time);
                if( $flag['state'] == true ) {
                    return response()->json(['state'=>true, 'start_time'=>  $flag['start_time'] ]);
                }
            } else {
               
                if ($available_day->day > $c_dayofweek ) {
                   $s_time =  date('Y-m-d', strtotime($current_day. ' + '.($available_day->day - $c_dayofweek).' days'))." ".$available_day->from.":00:00";
                   $e_time =  date('Y-m-d', strtotime($current_day. ' + '.($available_day->day -$c_dayofweek).' days'))." ".$available_day->to.":00:00";
                } else {
                    $s_time =  date('Y-m-d', strtotime($current_day. ' + '.(7 - $c_dayofweek + $available_day->day).' days'))." ".$available_day->from.":00:00";
                    $e_time =  date('Y-m-d', strtotime($current_day. ' + '.(7 - $c_dayofweek + $available_day->day).' days'))." ".$available_day->to.":00:00";
                }
                $flag = $this->getTimes($doctor, $duration, $s_time, $e_time, $current_time);
           
                if( $flag['state'] == true ) {
                    return response()->json(['state'=>true, 'start_time'=>  $flag['start_time'] ]);
                }
            }
        }
       // return response()->json(['state'=>true, 'start_time'=> $current_time ]);
    }

 

    public function destroy($id)
    {
            $appointment = Appointment::findOrFail($id);
            $appointment->delete();

            return redirect('/reception/appointment')->with('success', 'Appointment Data is successfully deleted');
    }
    
}
