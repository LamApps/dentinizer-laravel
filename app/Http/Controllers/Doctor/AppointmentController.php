<?php

namespace App\Http\Controllers\Doctor;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Notification;
use App\Models\User;

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
        $events = DB::select('SELECT appointments.id, 
                                                patients.email AS p_email,
                                                patients.id AS p_id,
                                                patients.ar_name AS p_ar_name,
                                                patients.name AS p_name,
                                                appointments.start_time, 
                                                (appointments.start_time + INTERVAL appointments.duration MINUTE) AS end, 
                                                appointments.comments, 
                                                appointments.status 
                                                FROM appointments
                                    LEFT JOIN users ON appointments.doctor_id = users.id
                                    LEFT JOIN patients ON patients.id = appointments.patient_id
                                    WHERE appointments.doctor_id = ?', [auth()->user()->id]);
        $doctors = Doctor::all();
        return view('doctor.appointment', compact('events', 'doctors'));
    }

    public function change_appointment(Request $req) {
        $success = false;
        $msg = 'Oops, something went wrong !';
        $appointment = Appointment::find($req->id);
        $appointment->status = $req->value;
        $appointment->save();
        return response ()->json ( [ 
            'success' => true,
            'msg' => 'Saved successfully!'
        ] );
    } 

    public function request_appointment(Request $req) {
        $notif = new Notification();
        $notif->owner_id = Auth::user()->id;
        $notif->owner_type = 'App\Models\Appointment';
        if(Auth::user()->id == $req->doctor_id) $target_doctor_name = "himself";
        else $target_doctor_name = User::find($req->doctor_id)->name;
        $notif->notification = Auth::user()->name." wants to book a new appoinment for ".$target_doctor_name;
        $notif->to_id = $req->doctor_id;
        $notif->message_type = 12;
        $notif->save();
        return response ()->json ( [ 
            'success' => true,
            'msg' => 'Your request has been sent successfully!'
        ] );        
    }
}
