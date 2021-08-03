<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Invoice;
use App\Models\Patient;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\Invoicerefund;
use App\Models\Invoicepayment;
use App\Models\Patientprofile;
use App\Library\Helpers\Helper;
use App\Models\Medicalcondition;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Procedureserviceitem;
use Illuminate\Support\Facades\Auth;
use App\Library\Services\DbHelperTools;


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
        return view('admin.patient',compact('patients')); */
        return view('patient.list');
    }

    public function store(Request $data) 
    {
        Patient::updateOrCreate(
            [
                'id' => $data['id']
            ],
            [
            'name' => $data['name'],
            'email' => $data['email'],
            'birthday' => $data['birthday'],
            'address' => $data['address'],
            'phone' => $data['phone'],
            'state' => 0,
        ]);

        return response()->json(['success'=>'Ajax request submitted successfully']);
    }


    public function patient_profile($id)
    {
        $patient_id = $id;

        $services = DB::select("SELECT patient_notes.id, patient_notes.patient_id, patient_notes.teeth_id, patient_notes.note, patient_notes.category_id, patient_notes.type, service_categories.name, services.price FROM patient_notes 
                                    LEFT JOIN service_categories on patient_notes.category_id = service_categories.id
                                    left join services on service_categories.id = services.category_id
                                    WHERE patient_notes.patient_id = ? 
                                    GROUP BY patient_notes.id", [$id]);
       // $services = json_encode($service);


       $patient_data = DB::select("SELECT * FROM patients WHERE id=?", [$id]);
       $name = explode(" ", $patient_data[0]->name);
       if(count($name) == 2)
           $short_name = $name[0][0].$name[1][0];
       else if(count($name) == 1)
           $short_name = $short_name = $name[0][0].$name[0][1];

        $data = DB::select("SELECT * FROM service_categories");
        $cat_arrs = array();
        foreach($data as $row) { 
            $cat_arrs[] = array(
                "id" => $row ->id,
                "parent" => $row->parent_id,
                "text" => $row->name
            );
        }
        $datas = json_encode($cat_arrs);

        $invoices = DB::select("SELECT invoices.id, invoices.code, invoices.from, users.email AS d_email, invoices.to, patients.email AS p_email, t.amount  FROM invoices
            LEFT JOIN users ON invoices.from  = users.id
            LEFT JOIN patients ON invoices.to = patients.id
            LEFT JOIN 
                (SELECT invoice_lists.invoice_code, SUM(invoice_lists.amount) AS amount FROM invoice_lists GROUP BY invoice_lists.invoice_code) AS t ON t.invoice_code = invoices.code
            WHERE invoices.to = ?
        ", [$id]);

        $storages = DB::select("SELECT * FROM patient_storage WHERE patient_id=?", [$id]);

        return view('admin.patient_profile', compact('patient_id', 'datas', 'services', 'invoices', 'storages', 'patient_data', 'short_name'));
    }


    public function profileStore(Request $data)
    {   
        $flag = DB::select("SELECT * FROM patient_notes WHERE category_id = ?", [$data['category']]);

        if ( isset($data['id']) ) {
            $state = Patientprofile::updateOrCreate(
                [
                    'id' => $data['id']
                ],
                [
                'patient_id' => $data['patient_id'],
                'category_id' => $data['category'],
                'teeth_id' => $data['teeth_id'],
                'note' => $data['notes'],
            ]);
            return response()->json(['success'=>'Ajax request submitted successfully', 'state' => $state]);
        } else if (count($flag) == 0 && !isset($data['id']) ) {
            $state = Patientprofile::updateOrCreate(
                [
                    'id' => $data['id']
                ],
                [
                'patient_id' => $data['patient_id'],
                'category_id' => $data['category'],
                'teeth_id' => $data['teeth_id'],
                'note' => $data['notes'],
            ]);
            return response()->json(['success'=>'Ajax request submitted successfully', 'state' => $state]);
        } else if (count($flag) > 0 && !isset($data['id']) ) {
            return response()->json(['success'=>'Ajax request submitted successfully', 'state' => 0]);
        }
        
    }


    public function destroy($id)
    {
            $patient = Patient::findOrFail($id);
            $patient->delete();
            return redirect('/admin/patient')->with('success', 'Patient Data is successfully deleted');
    }

    public function profile_destroy($id)
    {
            $patient = Patientprofile::findOrFail($id);
            $patient->delete();
            return back();
    }

    public function sdtPatients(Request $request)
    {
        $data=$meta=[];

        //dd($request->all());
        $limit=$request->limit;
        if($limit>0){
            $patients = Patient::select('id','name','ar_name','birthday','address','phone','state')->limit($limit)->get();
        }else{
            $patients = Patient::select('id','name','ar_name','birthday','address','phone','state')->get();
        }
        $DbHelperTools=new DbHelperTools();
        $canAddApointment=(Auth::user()->user_type=='reception')?true:false;


        if ($request->isMethod('post')) {
            if ($request->has('filter_text') && !empty($request->filter_text)) {
                $patients=Patient::select('id','name','ar_name','birthday','address','phone','state')->where('name', 'like', '%'.$request->filter_text.'%')
                ->orWhere('ar_name', 'like', '%'.$request->filter_text.'%')->get();
            }
        }

        foreach ($patients as $patient) {
            $row=array();
                //<th>ID</th>
                $row[]=$patient->id;
                //<th>Name</th>
                $name=($patient->name)?'<a href="/profile/patient/'.$patient->id.'">'.$patient->name.'</a>':'';
                $ar_name=($patient->ar_name)?'<a href="/profile/patient/'.$patient->id.'">'.$patient->ar_name.'</a>':'';
                $row[]=$name.' '.$ar_name;
                //<th>Email</th>
                // $row[]=$patient->email;
                //<th>Birthday</th>
                /* $row[]=$patient->birthday;
                //<th>Address</th>
                $row[]=$patient->address; */
                // <th>Phone</th>
                $row[]=$patient->phone;
                // <th>Status</th>
                $status='Open';
                $cssClass='success';
                if($patient->state == 1){
                    $status='Complete';
                    $cssClass='warning';
                }
                $row[]='<span class="badge badge-light-'.$cssClass.'">'.$status.'</span>';
                //Appointment
                $btn_appointment='';
                if($canAddApointment)
                    $btn_appointment='<button type="button" onclick="_formAppointment(0,'.$patient->id.')" class="btn btn-sm btn-outline-primary">'.Helper::getSvgIconeByAction('NEW').' '.__('locale.book_appointment').'</button>';

                $tb=$DbHelperTools->getAppointmentsPatient($patient->id);
                $info='<p class="text-info"><strong>- '.$tb['nb_appointment'].'</strong> appointment(s)</p>';
                $lastAppt=($tb['from'])?'<p class="text-primary">- Last appointment from: <strong>'.$tb['from'].'</strong> to : <strong>'.$tb['to'].'</strong></p>':'';
                $row[]=$info.$lastAppt.$btn_appointment;
                // <th>Actions</th>
                $btn_view='<a class="btn btn-icon btn-sm btn-outline-primary" href="/profile/patient/'.$patient->id.'">'.Helper::getSvgIconeByAction('VIEW').'</a>';
                $btn_edit='<button type="button" onclick="_formPatient('.$patient->id.')" class="btn btn-icon btn-sm btn-outline-primary">'.Helper::getSvgIconeByAction('EDIT').'</button>';
                $btn_delete='<button class="btn btn-icon btn-sm btn-outline-primary" onclick="_deletePatient('.$patient->id.')" title="Delete">'.Helper::getSvgIconeByAction('DELETE').'</button>';
                
                
                $row[]='<div class="btn-group">'.$btn_edit.$btn_view.$btn_delete.'</div>';
            $data[]=$row;
        }    
        $result = [
            'data' => $data,
        ];
        return response()->json($result);
    }
    public function formPatient($patient_id){
        $patient=null;
        $medicalconditionsList=Medicalcondition::all();
        if ($patient_id > 0) {
                $patient = Patient::find ( $patient_id );
        }
        return view('patient.form',compact('patient','medicalconditionsList'));
    }
    public function storeFormPatient(Request $request) {
		$success = false;
        $msg = 'Oops, something went wrong !';
        if ($request->isMethod('post')) {
            //dd($request->all());
            //$DbHelperTools=new DbHelperTools();
            $birthday_date =null;
            if ($request->has('birthday') && isset($request->birthday)) {
                $birthday_date = Carbon::createFromFormat('Y-m-d',$request->birthday);
            }

            $medical_conditions_list =null;
            if ($request->has('medical_conditions') && isset($request->medical_conditions)) {
                $medical_conditions_list = implode(";",$request->medical_conditions);
            }
            //dd($medical_conditions_list);
            Patient::updateOrCreate(
                [
                    'id' => $request->id
                ],
                [
                'name' => $request->name,
                'ar_name' => $request->ar_name,
                'email' => $request->email,
                'birthday' => $birthday_date,
                'address' => $request->address,
                'phone' => $request->phone,
                'state' => $request->state,
                'nationality' => $request->nationality,
                'iqama_id' => $request->iqama_id,
                'medical_conditions' => $medical_conditions_list,
            ]);
            $success = true;
            $msg = 'Your patient has been saved successfully';
        }         
        return response ()->json ( [ 
                'success' => $success,
                'msg' => $msg
        ] );
    }
    public function deletePatient($id){
        $success = false;
        if($id>0){
            //pr_procedure_service_items
            Procedureserviceitem::where('patient_id', $id)->forceDelete();
            //inv_invoice_payments
            $idsInvoices=Invoice::select('id')->where('patient_id', $id)->pluck('id');
            //dd($idsInvoices);
            if(count($idsInvoices)>0){
                Invoicepayment::whereIn('invoice_id', $idsInvoices)->forceDelete();
                Invoicerefund::whereIn('invoice_id', $idsInvoices)->forceDelete();
            }
            Invoice::select('id')->where('patient_id', $id)->forceDelete();
            //appointments
            Appointment::where('patient_id', $id)->forceDelete();
            Patient::where('id', $id)->forceDelete();
            $success = true;
        }
        return response()->json(['success'=>$success]);
    }
}
