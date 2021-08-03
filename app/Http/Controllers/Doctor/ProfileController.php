<?php

namespace App\Http\Controllers\Doctor;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Patientprofile;
use App\Models\Storage;
use App\Models\Invoice;
use App\Models\Invoicelist;
use App\Models\User;
use App\Models\note;
use Auth;
use PDF;


class ProfileController extends Controller
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
    public function index($id)
    {
        $patient_id = $id;
        $doctor_id  = auth()->user()->id;

        $services = DB::select("SELECT patient_notes.id, patient_notes.patient_id, patient_notes.teeth_id,patient_notes.invoiced, patient_notes.note, patient_notes.category_id, patient_notes.type, service_categories.name, services.price FROM patient_notes 
                                    LEFT JOIN service_categories on patient_notes.category_id = service_categories.id
                                    left join services on service_categories.id = services.category_id
                                    WHERE patient_notes.patient_id = ?                                
                                    GROUP BY patient_notes.id", [$id]);


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
                "parent" => $row -> parent_id,
                "text" => $row -> name
            );
        }
        $datas = json_encode($cat_arrs);

        $storages = DB::select("SELECT * FROM patient_storage WHERE patient_id=?", [$id]);

        $invoices = DB::select("SELECT invoices.id, invoices.code,invoices.paid,invoices.from, users.email AS d_email, invoices.to, patients.email AS p_email, t.amount  FROM invoices
                                    LEFT JOIN users ON invoices.from  = users.id
                                    LEFT JOIN patients ON invoices.to = patients.id
                                    LEFT JOIN 
                                        (SELECT invoice_lists.invoice_code, SUM(invoice_lists.amount) AS amount FROM invoice_lists GROUP BY invoice_lists.invoice_code) AS t ON t.invoice_code = invoices.code
                                    WHERE invoices.to = ?
                                ", [$id]);

        $total = 0;
        $dept  = 0;
        $paid  = 0;
        $notes = DB::table('notes')->where('user_id',$doctor_id)->where('patient_id',$patient_id)->get();
        return view('doctor.profile', compact('patient_id','doctor_id','datas','notes','services', 'invoices', 'patient_data', 'short_name', 'storages','total','dept','paid'));
    }

    public function profileStore(Request $data)
    {   
        $flag         = DB::select("SELECT * FROM patient_notes WHERE category_id = ?", [$data['category']]);
        $categoryinfo = DB::table('service_categories')->where('id',$data['category'])->first();
        $serviceinfo  = DB::table('services')->where('category_id',$data['category'])->first();
        
        if (isset($data['id']) ) {
            $state = Patientprofile::updateOrCreate(
                [
                    'id' => $data['id'],
                ],
                [
                    'patient_id'  => $data['patient_id'],
                    'doctor_id'   => auth()->user()->id,
                    'category_id' => $data['category'],
                    'teeth_id'    => $data['teeth_id'],
                    'note'        => $data['notes'],
                    'type'        => $data['type'],
                    'invoiced'    => 0,
            ]);
            $state['service'] = $categoryinfo->name;
            $state['amount'] = $serviceinfo ?  $serviceinfo->price : '';
            return response()->json(['success'=>'Ajax request submitted successfully', 'state' => $state]);
        } else if (count($flag) == 0 && !isset($data['id']) ) {
            $state = Patientprofile::updateOrCreate(
                [
                    'id' => $data['id'],
                ],
                [
                    'patient_id' => $data['patient_id'],
                    'doctor_id' => auth()->user()->id,
                    'category_id' => $data['category'],
                    'teeth_id' => $data['teeth_id'],
                    'note' => $data['notes'],
                    'type' => $data['type'],
                    'invoiced' => 0,
            ]);
            $state['service'] = $categoryinfo->name;
            $state['amount'] = $serviceinfo ?  $serviceinfo->price : '';
            return response()->json(['success'=>'Ajax request submitted successfully', 'state' => $state]);
        } else if (count($flag) > 0 && !isset($data['id']) ) {
            $state = Patientprofile::updateOrCreate(
                [
                    'id' => $data['id'],
                ],
                [
                    'patient_id' => $data['patient_id'],
                    'doctor_id' => auth()->user()->id,
                    'category_id' => $data['category'],
                    'teeth_id' => $data['teeth_id'],
                    'note' => $data['notes'],
                    'type' => $data['type'],
                    'invoiced' => 0,
            ]);
            $state['service'] = $categoryinfo->name;
            $state['amount'] = $serviceinfo ?  $serviceinfo->price : '';
            return response()->json(['success'=>'Ajax request submitted successfully', 'state' => $state]);
        }
    }

    public function BillingStore(Request $request)
    {
        $service_ids      = $request->servic_ids;
        $total            = 0;


        $newbilling       = new Invoice;
        $newbilling->code = time();
        $newbilling->from = auth()->user()->id;
        $newbilling->to   = $request->patient_id;
        $newbilling->save();

        foreach($service_ids as $serservice_id)
        {
            $servicearr = DB::select("SELECT patient_notes.id, patient_notes.patient_id,patient_notes.doctor_id, patient_notes.teeth_id, patient_notes.note, patient_notes.category_id, patient_notes.type, service_categories.name, services.price FROM patient_notes 
                                    LEFT JOIN service_categories on patient_notes.category_id = service_categories.id
                                    left join services on service_categories.id = services.category_id
                                    WHERE patient_notes.id = ?                                
                                    GROUP BY patient_notes.id", [$serservice_id]);
            $service = json_decode(json_encode($servicearr), true);

            $newInvoicelist                = new Invoicelist;
            $newInvoicelist->invoice_id    = $newbilling->id;
            $newInvoicelist->invoice_code  = $newbilling->code;
            $newInvoicelist->teeth_id      = $service['0']['teeth_id'];
            $newInvoicelist->service       = $service['0']['name'];
            $newInvoicelist->amount        = $service['0']['price'] ? $service['0']['price'] : 0;
            $newInvoicelist->save();
            
            $total += $service['0']['price'];
            DB::table('patient_notes')->where('id',$serservice_id)->update(['invoiced' => 1]);
        }
        DB::table('invoices')->where('id',$newbilling->id)->update(['total' => $total]);
        return back()->with('success_paid_invoice', '1');
    }

    public function BillingPaid(Request $request)
    {
        $id = $request->invoiceid;
        DB::table('invoices')->where('id',$id)->update(['paid' => 1]);
         return back()->with('success_paid_invoice', '1');
    }

    public function notestore(Request $request)
    {
        $data     = $request->all();
        $newnote  = note::create($data);
        return back()->with('success_add_note', '100');
    }

    public function notedestroy(Request $request,$id)
    {
        note::findorfail($id)->delete();
        return back()->with('success_add_note', '100');
    }

     public function generatepdf($id)
    {
        $showInvoice    = Invoice::findorfail($id);
        $Invoicedetails = Invoicelist::where('invoice_id',$id)->get();
        $doctorinfo     = User::where('id',$showInvoice->from)->first();
        $patientinfo    = User::where('id',$showInvoice->to)->first();
        $pdf            = PDF::loadView('pdf.invoice', compact('showInvoice','Invoicedetails','doctorinfo','patientinfo'));
		return $pdf->stream('invoice.pdf');
    }
   
}
