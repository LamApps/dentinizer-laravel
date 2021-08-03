<?php

namespace App\Http\Controllers\Doctor;

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
   
    public function store(Request $data) 
    {
        Invoice::create(
            [
            'code' => $data['code'],
            'from' => $data['from'],
            'to' => $data['to']
            ]);

        foreach ($data['invoices'] as $invoice) {
            if ( $invoice['price'] == null)
                $price = 0;
            else 
                $price = $invoice['price'];
            Invoicelist::create(
                [
                'invoice_code' => $data['code'],
                'teeth_id' => $invoice['teeth_id'],
                'service' => $invoice['s_name'],
                'amount' => $price,
            ]);
        }


        foreach ($data['invoice_flags'] as $flag) {
            DB::table('patient_notes')->where('id', $flag)->update(['invoiced' => 1]); 
        }

        return response()->json(['success'=>'Ajax request submitted successfully']);
    }


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


    public function getinvoicelist($code) 
    {
       // $lists = Invoicelist::all()->where('invoice_code', '#'.$code);
        $lists = DB::select("SELECT * FROM invoice_lists WHERE invoice_code =?", ['#'.$code]);
        return response()->json($lists);
    }

}
