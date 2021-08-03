<?php

namespace App\Http\Controllers\Reception;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Invoicelist;


class InvoiceController extends Controller
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
        $patients = Patient::all();
        $doctors  = User::all()->where('user_type', 'doctor')->where('state', 1);

        $invoices = DB::select("SELECT invoices.id, invoices.code, invoices.from, users.email AS d_email, invoices.to, patients.email AS p_email, t.amount  FROM invoices
                                    LEFT JOIN users ON invoices.from  = users.id
                                    LEFT JOIN patients ON invoices.to = patients.id
                                    LEFT JOIN (SELECT invoice_lists.invoice_code, SUM(invoice_lists.amount) AS amount FROM invoice_lists GROUP BY invoice_lists.invoice_code) AS t ON t.invoice_code = invoices.code
                                ");

        $appointments = DB::select("SELECT appointments.*, users.email AS d_email, patients.email AS p_email FROM appointments
                                        LEFT JOIN users ON appointments.doctor_id = users.id
                                        LEFT JOIN patients ON appointments.patient_id = patients.id");
        
        $services = DB::table('services')->get();
        return view('reception.invoice',compact('patients', 'doctors', 'invoices', 'appointments','services'));
    }

    // public function store(Request $data) 
    // {
    //     Invoice::updateOrCreate(
    //         [
    //             'id' => $data['id']
    //         ],
    //         [
    //         'code' => $data['code'],
    //         'from' => $data['from'],
    //         'to' => $data['to']
    //     ]);
    //     return response()->json(['success'=>'Ajax request submitted successfully']);
    // }

    public function liststore(Request $data) 
    {
        $code = $data['code'];
        $list  = json_decode($data['listdata']);
        foreach ($list as $p) {
           $description = $p[0];
           $amount = $p[1];

           Invoicelist::updateOrCreate(
                [
                    'id' => $data['id']
                ],
                [
                'invoice_code' => $code,
                'description' => $description,
                'amount' => $amount
            ]);
        }
        
        return response()->json(['success'=>'Ajax request submitted successfully']);
    }


    public function service_list($p_id, $d_id) 
    {

        $patient_id = $p_id;
        $doctor_id = $d_id;

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
            GROUP BY patient_notes.id', [$doctor_id, $patient_id]));
        
        $patient = DB::select('SELECT * FROM patients WHERE id=?', [$patient_id]);
        $doctor = DB::select('SELECT * FROM users WHERE id=?', [$doctor_id]);

        return view('reception.invoice_plan', compact('patient_id', 'doctor_id', 'plans', 'patient', 'doctor'));
    }

    public function complete($plan_id, $patient_id, $doctor_id)
    {
        DB::table('patient_notes')->where('id', $plan_id)->update(['type' => 'completed']); 
        return redirect('/reception/invoice/'.$patient_id."/".$doctor_id)->with('success', 'Staff Data is successfully deleted');
    }


    public function store(Request $data) 
    {
        $newinvoice = Invoice::create(
            [
                'code'  => $data['code'],
                'from'  => $data['from'],
                'to'    => $data['to'],
                'total' => $data['total'],
            ]);

        foreach($data['invoices'] as $invoice) {
            $serviceinfo = DB::table('services')->where('id',$invoice)->first();
            Invoicelist::create(
            [
                'invoice_code' => $data['code'],
                'teeth_id'     => 0,
                'service'      => $serviceinfo->service_name,
                'amount'       => $serviceinfo->price,
                'invoice_id'   => $newinvoice->id,
            ]);
        }

        return response()->json(['success'=>'Ajax request submitted successfully']);
    }

    public function getinvoicelist($code) 
    {
       // $lists = Invoicelist::all()->where('invoice_code', '#'.$code);
        $lists = DB::select("SELECT * FROM invoice_lists WHERE invoice_code =?", ['#'.$code]);
        return response()->json($lists);
    }

}
