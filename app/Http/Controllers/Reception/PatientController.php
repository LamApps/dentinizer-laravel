<?php

namespace App\Http\Controllers\Reception;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use DB;
use Carbon\Carbon;


class PatientController extends Controller
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
        $doctors  = User::all()->where('user_type', 'doctor')->where('state', 1);
        $services = DB::table('services')->get();
        return view('reception.patient',compact('patients','doctors','services')); */
        return view('patient.list');
    }

    public function store(Request $data) 
    {
        
        $birthday_date = Carbon::createFromFormat('Y-m-d',$data['birthday']);
        //dd($birthday_date);
        Patient::updateOrCreate(
            [
                'id' => $data['id']
            ],
            [
            'name' => $data['name'],
            'ar_name' => $data['ar_name'],
            'email' => $data['email'],
            'birthday' => $birthday_date,
            'address' => $data['address'],
            'phone' => $data['phone'],
            'state' => 0,
        ]);
        return response()->json(['success'=>'Ajax request submitted successfully']);
    }

    public function show($id){
        $patient_id = $id;

        $services = DB::select("SELECT patient_notes.id, patient_notes.patient_id,patient_notes.doctor_id, patient_notes.teeth_id,patient_notes.invoiced, patient_notes.note,patient_notes.type, patient_notes.category_id, service_categories.name, services.price 
                                FROM patient_notes 
                                    LEFT JOIN service_categories on patient_notes.category_id = service_categories.id
                                    left join services on service_categories.id = services.category_id
                                    WHERE patient_notes.patient_id = ? 
                                    GROUP BY patient_notes.id", [$patient_id]);


        $patient_data = DB::select("SELECT * FROM patients WHERE id=?", [$patient_id]);
        $name = explode(" ", $patient_data[0]->name);
        
        if(count($name) == 2)
           $short_name = $name[0][0].$name[1][0];
        else if(count($name) == 1)
           $short_name = $short_name = $name[0][0].$name[0][1];



        $data = DB::select("SELECT * FROM service_categories");
        $cat_arrs = array();
        foreach($data as $row) { 
            $cat_arrs[] = array(
                "id"     => $row ->id,
                "parent" => $row->parent_id,
                "text"   => $row->name
            );
        }
        $datas = json_encode($cat_arrs);

        $storages = DB::select("SELECT * FROM patient_storage WHERE patient_id=?", [$patient_id]);


        $invoices = DB::select("SELECT invoices.id, invoices.code, invoices.from,invoices.paid, users.email AS d_email, invoices.to, patients.email AS p_email, t.amount  FROM invoices
            LEFT JOIN users ON invoices.from  = users.id
            LEFT JOIN patients ON invoices.to = patients.id
            LEFT JOIN (SELECT invoice_lists.invoice_code, SUM(invoice_lists.amount) AS amount FROM invoice_lists GROUP BY invoice_lists.invoice_code) AS t ON t.invoice_code = invoices.code
            WHERE invoices.to = ?", [$patient_id]);
        
        $total = 0;
        $dept  = 0;
        $paid  = 0;

        $notes = DB::table('notes')->where('patient_id',$patient_id)->get();
        return view('reception.patientprofile1', compact('patient_id', 'datas','notes','services', 'invoices', 'patient_data', 'short_name', 'storages','total','paid','dept'));
    }


    public function destroy($id)
    {
            $patient = Patient::findOrFail($id);
            $patient->delete();

            return redirect('/reception/patient')->with('success', 'Staff Data is successfully deleted');
    }

    public function BillingPaid(Request $request)
    {
        $id = $request->invoiceid;
        DB::table('invoices')->where('id',$id)->update(['paid' => 1]);
        return back()->with('success_paid_invoice', '1');
    }
}
