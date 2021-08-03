<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Service;
use App\Models\User;
use App\Models\Appointment;

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
        /* $patients = Patient::all();
        $doctors = User::all()->where('user_type', 'doctor');
        $services = Service::all();
       // $appointments = Appointment::all();
       $appointments = DB::select("SELECT appointments.*, users.email as d_email, patients.email as p_email 
                                                    FROM appointments
                                                    LEFT JOIN users ON users.id = appointments.doctor_id
                                                    LEFT JOIN patients ON patients.id = appointments.patient_id"); */
    $appointments = DB::table('appointments')
    ->join('users', 'users.id', '=', 'appointments.doctor_id')
                                                    ->join('patients', 'patients.id', '=', 'appointments.patient_id')
                                                    ->select('appointments.*', 'users.name as doctor_name','users.email as doctor_email', 'patients.id','patients.ar_name','patients.name')
                                                    ->get();
        //return view('admin.appointment',compact('appointments', 'patients', 'doctors'));
        return view('admin.appointment',compact('appointments'));
    }

}
