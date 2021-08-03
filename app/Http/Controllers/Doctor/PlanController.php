<?php

namespace App\Http\Controllers\Doctor;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Storage;

use Auth;


class PlanController extends Controller
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
                                        
        return view('doctor.plan', compact('patients'));
    }



    public function patient($id)
    {
      
        $patient_id = $id;

        $plans = json_encode(DB::select('SELECT patient_notes.id, 
                appointments.start_time AS start_time, 
                appointments.duration AS duration, 
                patient_notes.patient_id, 
                patients.name AS p_name, 
                patients.email AS p_email,
                patient_notes.teeth_id, 
                service_categories.name AS s_name, 
                services.price,
                patient_notes.type, 
                patient_notes.note, 
                patient_notes.category_id,
                patient_notes.invoiced
            FROM patient_notes 
            LEFT JOIN service_categories ON patient_notes.category_id = service_categories.id
            LEFT JOIN services ON service_categories.id = services.category_id

            LEFT JOIN appointments ON appointments.patient_id = patient_notes.patient_id
            LEFT JOIN users ON users.id = appointments.doctor_id
            LEFT JOIN patients ON patients.id = patient_notes.patient_id
            WHERE users.id = ? 
            AND patient_notes.patient_id = ? 
            GROUP BY patient_notes.id', [auth()->user()->id, $id]));
        
        $patient = DB::select('SELECT * FROM patients WHERE id=?', [$id]);

        return view('doctor.invoice_plan', compact('patient_id', 'plans', 'patient'));
    }


    public function complete($id)
    {
        DB::table('patient_notes')->where('id', $id)->update(['type' => 'completed']); 
        return redirect('/doctor/service/plan')->with('success', 'Staff Data is successfully deleted');
    }



    public function fileUploadPost(Request $req)
    {
        $fileName = time().'_'.$req->file->getClientOriginalName();
        $filePath = $req->file('file')->storeAs('uploads', $fileName, 'public');

        Storage::create([
            
            'patient_id' => $req['p_id'],
            'title' => $req['a_title'],
            'description' => $req['a_description'],
            'url' => $filePath,
        ]);

        return back()
            ->with('success_add_storage','You have successfully upload file.')
            ->with('file',$fileName);
   
    }

    public function destroy($id, $patient_id)
    {
        $storage = Storage::findOrFail($id);
        $storage->delete();

        return redirect('/doctor/service/patient/'.$patient_id)->with('success_add_storage', 'Staff Data is successfully deleted');
       // redirect(Request::url());
    }

    public function download($id)
    {
        $storage = Storage::where('id', $id)->firstOrFail();
        $pathToFile = storage_path('app\public/' . $storage->url);
        return response()->download($pathToFile);
    }
}
