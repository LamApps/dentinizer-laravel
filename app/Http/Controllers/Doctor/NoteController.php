<?php

namespace App\Http\Controllers\Doctor;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Appointment;

use Auth;


class NoteController extends Controller
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
        $patients = json_encode(DB::select('SELECT appointments.id, 
                                                patients.id AS p_id, 
                                                patients.name AS p_name, 
                                                patients.email AS p_email, 
                                                patients.birthday AS p_birthday, 
                                                patients.address AS p_address, 
                                                patients.phone AS p_phone, 
                                                patients.state AS p_state, 
                                                appointments.start_time AS start, 
                                                appointments.duration as end,
                                                appointments.comments AS DESCRIPTION
                                            FROM appointments
                                        LEFT JOIN users ON appointments.doctor_id = users.id
                                        LEFT JOIN patients ON patients.id = appointments.patient_id
                                        WHERE appointments.doctor_id = ?', [auth()->user()->id]));
                                        
        return view('doctor.note', compact('patients'));
    }
}
